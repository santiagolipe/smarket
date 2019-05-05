
window.Popper = require('tippy.js').default;

/**
 * We'll load the Tippy.js plugin.
 */

try {
    window.Tippy = require('tippy.js/umd/index.all.js').default;
} catch (e) {}
