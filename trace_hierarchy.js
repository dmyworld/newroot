const fs = require('fs');
const content = fs.readFileSync('c:/Users/user/Documents/GitHub/www/newroot/application/views/fixed/header-va.php', 'utf8');

const lines = content.split('\n');
let liStack = [];
let ulStack = [];
let errors = [];

lines.forEach((line, index) => {
    const lineNum = index + 1;
    // Find all li and ul tags
    const matches = line.matchAll(/<(li|ul)\b|<\/(li|ul)>/gi);

    for (const match of matches) {
        const tag = match[0].toLowerCase();
        if (tag === '<ul>' || tag.startsWith('<ul')) {
            ulStack.push(lineNum);
        } else if (tag === '</ul>') {
            ulStack.pop();
        } else if (tag === '<li>' || tag.startsWith('<li')) {
            // Check if we already have an open li and NO new ul since then
            if (liStack.length > 0) {
                const lastLiLine = liStack[liStack.length - 1];
                const lastUlLine = ulStack[ulStack.length - 1];
                if (lastLiLine > lastUlLine || ulStack.length === 0) {
                    // Wait! This is only an error if the NEW li is a child of the old one
                    // without a UL. 
                }
            }
            liStack.push(lineNum);
        } else if (tag === '</li>') {
            liStack.pop();
        }
    }
});
// (Simplifying: Manual stack trace is better)
