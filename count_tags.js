const fs = require('fs');
const lines = fs.readFileSync('c:/Users/user/Documents/GitHub/www/newroot/application/views/fixed/header-va.php', 'utf8').split('\n');

const countTagsInRange = (start, end) => {
    const segment = lines.slice(start - 1, end).join('\n');
    return {
        liOpen: (segment.match(/<li\b/gi) || []).length,
        liClose: (segment.match(/<\/li>/gi) || []).length,
        ulOpen: (segment.match(/<ul\b/gi) || []).length,
        ulClose: (segment.match(/<\/ul>/gi) || []).length
    };
};

console.log('--- MEGA MENU (915-1321) ---');
console.log(countTagsInRange(915, 1321));
console.log('--- SIDEBAR (1390-1773) ---');
console.log(countTagsInRange(1390, 1773));
console.log('--- ENTIRE FILE ---');
console.log(countTagsInRange(1, lines.length));
