const fs = require('fs');
const content = fs.readFileSync('c:/Users/user/Documents/GitHub/www/newroot/application/views/fixed/header-va.php', 'utf8');

const lines = content.split('\n');
let stack = [];
let errors = [];

lines.forEach((line, index) => {
    const lineNum = index + 1;
    // Regex to match opening and closing li tags, ignoring attributes and content
    const tags = line.match(/<(li)\b|<\/(li)>/g);

    if (tags) {
        tags.forEach(tag => {
            if (tag.startsWith('</')) {
                if (stack.length === 0) {
                    errors.push(`Line ${lineNum}: Found closing </li> without opening`);
                } else {
                    stack.pop();
                }
            } else {
                stack.push(lineNum);
            }
        });
    }
});

while (stack.length > 0) {
    errors.push(`Line ${stack.pop()}: Unclosed <li> tag starts here`);
}

console.log('--- ERROR REPORT ---');
if (errors.length === 0) {
    console.log('No li tag mismatches found.');
} else {
    errors.forEach(e => console.log(e));
}
console.log('--------------------');
