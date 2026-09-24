const fs = require('fs');
const css = fs.readFileSync('public/build/assets/app-CkZYvl_0.css', 'utf8');
const checks = ['bg-amber-600/10', 'bg-green-600/10', 'ring-3', 'bg-muted/50', 'bg-green-400/10', 'text-amber-400'];
for (const c of checks) {
    console.log(c + ':', css.includes(c) ? 'found' : 'missing');
}
