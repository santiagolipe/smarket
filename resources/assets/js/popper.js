
window.Popper = require('popper.js').default;

/**
 * We'll load the Popper.js plugin.
 */

try {
    window.Popper = require('popper.js/dist/popper.js').default;
} catch (e) {}
