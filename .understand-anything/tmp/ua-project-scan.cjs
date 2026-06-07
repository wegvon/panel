#!/usr/bin/env node
const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

const root = process.argv[2];
const outputPath = process.argv[3];

if (!root || !outputPath) {
  console.error('Usage: node ua-project-scan.js <project-root> <output-path>');
  process.exit(1);
}

function log(msg) {
  process.stderr.write(`[scan] ${msg}\n`);
}

// --- Step 1: File Discovery ---
log('Step 1: File discovery via git ls-files...');
let allFiles;
try {
  const result = execSync('git ls-files', { cwd: root, encoding: 'utf8', maxBuffer: 50 * 1024 * 1024 });
  allFiles = result.trim().split('\n').filter(Boolean);
} catch {
  log('git ls-files failed, falling back to directory walk...');
  const walk = (dir) => {
    const entries = fs.readdirSync(dir, { withFileTypes: true });
    let results = [];
    for (const e of entries) {
      const full = path.join(dir, e.name);
      if (e.isDirectory()) results = results.concat(walk(full));
      else results.push(path.relative(root, full));
    }
    return results;
  };
  allFiles = walk(root);
}
log(`Found ${allFiles.length} tracked files.`);

// --- Step 2: Hardcoded Exclusions ---
const excludePatterns = [
  /(^|\/)node_modules(\/|$)/,
  /(^|\/)\.git(\/|$)/,
  /(^|\/)vendor(\/|$)/,
  /(^|\/)venv(\/|$)/,
  /(^|\/)\.venv(\/|$)/,
  /(^|\/)__pycache__(\/|$)/,
  /(^|\/)dist(\/|$)/,
  /(^|\/)build(\/|$)/,
  /(^|\/)out(\/|$)/,
  /(^|\/)coverage(\/|$)/,
  /(^|\/)\.next(\/|$)/,
  /(^|\/)\.cache(\/|$)/,
  /(^|\/)\.turbo(\/|$)/,
  /(^|\/)target(\/|$)/,
  /(^|\/)obj(\/|$)/,
  /\.lock$/,
  /^package-lock\.json$/,
  /^yarn\.lock$/,
  /^pnpm-lock\.yaml$/,
  /\.png$/, /\.jpg$/, /\.jpeg$/, /\.gif$/, /\.svg$/, /\.ico$/,
  /\.woff$/, /\.woff2$/, /\.ttf$/, /\.eot$/,
  /\.mp3$/, /\.mp4$/, /\.pdf$/, /\.zip$/, /\.tar$/, /\.gz$/,
  /\.min\.js$/, /\.min\.css$/, /\.map$/,
  /\.generated\.[^.]+$/,
  /(^|\/)\.idea(\/|$)/,
  /(^|\/)\.vscode(\/|$)/,
  /^LICENSE$/,
  /^\.gitignore$/,
  /^\.editorconfig$/,
  /\.prettierrc/,
  /\.eslintrc/,
  /\.log$/,
];

let filteredFiles = allFiles.filter(f => {
  return !excludePatterns.some(p => p.test(f));
});
log(`After hardcoded exclusions: ${filteredFiles.length} files.`);

// --- Step 2.5: .understandignore ---
const ignoreFiles = [
  path.join(root, '.understand-anything', '.understandignore'),
  path.join(root, '.understandignore'),
];

let filteredByIgnore = 0;
for (const ignorePath of ignoreFiles) {
  if (fs.existsSync(ignorePath)) {
    log(`Applying .understandignore: ${path.relative(root, ignorePath)}`);
    const lines = fs.readFileSync(ignorePath, 'utf8')
      .split('\n')
      .map(l => l.trim())
      .filter(l => l && !l.startsWith('#'));
    const before = filteredFiles.length;
    // Simple glob matching for ignore patterns
    const patterns = lines.map(line => {
      const negate = line.startsWith('!');
      const pat = negate ? line.slice(1) : line;
      const regex = new RegExp(
        '^' + pat
          .replace(/\./g, '\\.')
          .replace(/\*/g, '.*')
          .replace(/\?/g, '.')
          .replace(/\/$/, '(/|$)')
        + (pat.endsWith('/') ? '' : '(/.+)?$')
      );
      return { negate, regex };
    });
    filteredFiles = filteredFiles.filter(f => {
      let include = true;
      for (const { negate, regex } of patterns) {
        if (regex.test(f)) {
          include = negate;
        }
      }
      return include;
    });
    filteredByIgnore = before - filteredFiles.length;
    log(`  Removed ${filteredByIgnore} files via .understandignore.`);
  }
}

// --- Step 3: Language Detection ---
const extToLang = {
  '.ts': 'typescript', '.tsx': 'typescript',
  '.js': 'javascript', '.jsx': 'javascript',
  '.py': 'python',
  '.go': 'go',
  '.rs': 'rust',
  '.java': 'java',
  '.rb': 'ruby',
  '.cpp': 'cpp', '.cc': 'cpp', '.cxx': 'cpp', '.h': 'cpp', '.hpp': 'cpp',
  '.c': 'c',
  '.cs': 'csharp',
  '.swift': 'swift',
  '.kt': 'kotlin',
  '.php': 'php',
  '.vue': 'vue',
  '.svelte': 'svelte',
  '.sh': 'shell', '.bash': 'shell',
  '.ps1': 'powershell',
  '.bat': 'batch', '.cmd': 'batch',
  '.md': 'markdown', '.rst': 'markdown',
  '.yaml': 'yaml', '.yml': 'yaml',
  '.json': 'json',
  '.jsonc': 'jsonc',
  '.toml': 'toml',
  '.sql': 'sql',
  '.graphql': 'graphql', '.gql': 'graphql',
  '.proto': 'protobuf',
  '.tf': 'terraform', '.tfvars': 'terraform',
  '.html': 'html', '.htm': 'html',
  '.css': 'css', '.scss': 'css', '.sass': 'css', '.less': 'css',
  '.xml': 'xml',
  '.cfg': 'config', '.ini': 'config', '.env': 'config',
};

const specialFiles = {
  'Dockerfile': 'dockerfile',
  'Makefile': 'makefile',
  'Jenkinsfile': 'jenkinsfile',
};

function getLanguage(filePath) {
  const basename = path.basename(filePath);
  if (specialFiles[basename]) return specialFiles[basename];
  const ext = path.extname(filePath).toLowerCase();
  if (extToLang[ext]) return extToLang[ext];
  if (ext) return ext.slice(1);
  return 'unknown';
}

// --- Step 4: File Category Detection ---
function getFileCategory(filePath) {
  const basename = path.basename(filePath);
  const ext = path.extname(filePath).toLowerCase();

  // docs
  if (['.md', '.rst'].includes(ext)) return 'docs';
  if (ext === '.txt' && basename !== 'LICENSE') return 'docs';

  // infra (check before config because docker-compose.yml is infra)
  if (basename === 'Dockerfile') return 'infra';
  if (basename.startsWith('docker-compose.')) return 'infra';
  if (['.tf', '.tfvars'].includes(ext)) return 'infra';
  if (['Makefile', 'Jenkinsfile', 'Procfile', 'Vagrantfile'].includes(basename)) return 'infra';
  if (filePath.startsWith('.github/workflows/')) return 'infra';
  if (basename === '.gitlab-ci.yml') return 'infra';
  if (filePath.startsWith('.circleci/')) return 'infra';
  if (filePath.match(/\.k8s\.ya?ml$/)) return 'infra';
  if (filePath.includes('k8s/') || filePath.includes('kubernetes/')) return 'infra';

  // data
  if (['.sql', '.graphql', '.gql', '.proto'].includes(ext)) return 'data';
  if (ext === '.csv') return 'data';
  if (basename.endsWith('.schema.json')) return 'data';
  if (ext === '.prisma' || basename === 'prisma') return 'data';

  // script
  if (['.sh', '.bash', '.ps1', '.bat'].includes(ext)) return 'script';

  // markup
  if (['.html', '.htm', '.css', '.scss', '.sass', '.less'].includes(ext)) return 'markup';

  // config
  if (['.yaml', '.yml', '.json', '.jsonc', '.toml', '.xml', '.cfg', '.ini', '.env'].includes(ext)) return 'config';
  // .env files without extension
  if (basename.startsWith('.env')) return 'config';

  // code
  return 'code';
}

// --- Process files ---
log('Processing files...');
const files = [];
const languages = new Set();

for (const filePath of filteredFiles) {
  const language = getLanguage(filePath);
  const fileCategory = getFileCategory(filePath);
  const fullPath = path.join(root, filePath);
  let sizeLines = 0;
  try {
    const content = fs.readFileSync(fullPath, 'utf8');
    sizeLines = content.split('\n').length;
  } catch {
    sizeLines = 0;
  }
  files.push({ path: filePath, language, sizeLines, fileCategory });
  languages.add(language);
}

files.sort((a, b) => a.path.localeCompare(b.path));
log(`Processed ${files.length} files, ${languages.size} languages.`);

// --- Step 6: Framework Detection ---
log('Step 6: Framework detection...');
const frameworks = new Set();

// Check composer.json for PHP frameworks
const composerPath = path.join(root, 'composer.json');
let composerData = null;
if (fs.existsSync(composerPath)) {
  composerData = JSON.parse(fs.readFileSync(composerPath, 'utf8'));
  const deps = { ...(composerData.require || {}), ...(composerData['require-dev'] || {}) };
  const phpFrameworks = {
    'laravel/framework': 'Laravel',
    'filament/filament': 'Filament',
    'livewire/livewire': 'Livewire',
    'laravel/passport': 'Laravel Passport',
    'laravel/socialite': 'Laravel Socialite',
    'symfony/http-foundation': 'Symfony',
    'laravel/tinker': 'Laravel Tinker',
    'owen-it/laravel-auditing': 'Laravel Auditing',
    'timacdonald/json-api': 'JSON:API',
    'spatie/laravel-query-builder': 'Spatie Query Builder',
    'qirolab/laravel-themer': 'Laravel Themer',
    'dedoc/scramble': 'Scramble',
  };
  for (const [key, name] of Object.entries(phpFrameworks)) {
    if (deps[key]) frameworks.add(name);
  }
  // Testing
  if (deps['phpunit/phpunit']) frameworks.add('PHPUnit');
  if (deps['larastan/larastan']) frameworks.add('Larastan');
  if (deps['laravel/pint']) frameworks.add('Laravel Pint');
}

// Check package.json for frontend frameworks
const pkgPath = path.join(root, 'package.json');
if (fs.existsSync(pkgPath)) {
  const pkg = JSON.parse(fs.readFileSync(pkgPath, 'utf8'));
  const deps = { ...(pkg.dependencies || {}), ...(pkg.devDependencies || {}) };
  const jsFrameworks = {
    'tailwindcss': 'Tailwind CSS',
    'alpinejs': 'Alpine.js',
    'vite': 'Vite',
    'react': 'React',
    'vue': 'Vue',
    'svelte': 'Svelte',
    'vitest': 'Vitest',
    'jest': 'Jest',
  };
  for (const [key, name] of Object.entries(jsFrameworks)) {
    if (deps[key]) frameworks.add(name);
  }
}

// Infrastructure detection
const hasDockerfile = filteredFiles.some(f => path.basename(f) === 'Dockerfile');
const hasDockerCompose = filteredFiles.some(f => path.basename(f).startsWith('docker-compose.'));
const hasGHWorkflows = filteredFiles.some(f => f.startsWith('.github/workflows/'));
const hasTF = filteredFiles.some(f => f.endsWith('.tf'));

if (hasDockerfile) frameworks.add('Docker');
if (hasDockerCompose) frameworks.add('Docker Compose');
if (hasGHWorkflows) frameworks.add('GitHub Actions');
if (hasTF) frameworks.add('Terraform');

log(`Frameworks detected: ${[...frameworks].join(', ')}`);

// --- Step 7: Complexity ---
let estimatedComplexity = 'small';
if (files.length > 500) estimatedComplexity = 'very-large';
else if (files.length > 150) estimatedComplexity = 'large';
else if (files.length > 30) estimatedComplexity = 'moderate';

// --- Step 8: Project Name ---
let name = path.basename(root);
if (composerData && composerData.name) name = composerData.name;
log(`Project name: ${name}`);

// --- Step 9: Import Resolution (PHP) ---
log('Step 9: Import resolution...');
const importMap = {};
const autoloadPsr4 = (composerData && composerData.autoload && composerData.autoload['psr-4']) || {};

// Build reverse lookup: namespace prefix -> directory
const nsMap = Object.entries(autoloadPsr4).map(([ns, dir]) => ({
  prefix: ns.replace(/\\$/, ''),
  dir: dir.replace(/\/$/, ''),
}));

const codeFiles = files.filter(f => f.fileCategory === 'code');
const fileSet = new Set(filteredFiles);

for (const file of files) {
  if (file.fileCategory === 'code' && file.path.endsWith('.php')) {
    const fullPath = path.join(root, file.path);
    try {
      const content = fs.readFileSync(fullPath, 'utf8');
      const imports = [];

      // Match PHP use statements: use Namespace\Class;
      const useRegex = /^use\s+([A-Za-z_][\w\\]+)(?:\s+as\s+\w+)?\s*;/gm;
      let match;
      while ((match = useRegex.exec(content)) !== null) {
        const fqcn = match[1];
        // Try to resolve against PSR-4 autoload
        for (const { prefix, dir } of nsMap) {
          if (fqcn.startsWith(prefix + '\\')) {
            const relativePath = fqcn.slice(prefix.length + 1).replace(/\\/g, '/');
            const candidate = dir + '/' + relativePath + '.php';
            if (fileSet.has(candidate)) {
              imports.push(candidate);
              break;
            }
          }
        }
      }

      importMap[file.path] = imports;
    } catch {
      importMap[file.path] = [];
    }
  } else {
    importMap[file.path] = [];
  }
}

// Read README
let readmeHead = '';
const readmePath = path.join(root, 'README.md');
if (fs.existsSync(readmePath)) {
  readmeHead = fs.readFileSync(readmePath, 'utf8').split('\n').slice(0, 10).join('\n');
}

// Read raw description from composer.json
let rawDescription = '';
if (composerData && composerData.description) {
  rawDescription = composerData.description;
}

// Write results
const result = {
  scriptCompleted: true,
  name,
  rawDescription,
  readmeHead,
  languages: [...languages].sort(),
  frameworks: [...frameworks].sort(),
  files,
  totalFiles: files.length,
  filteredByIgnore,
  estimatedComplexity,
  importMap,
};

fs.writeFileSync(outputPath, JSON.stringify(result, null, 2));
log(`Scan complete. ${files.length} files written to ${outputPath}`);
