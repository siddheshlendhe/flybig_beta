function copyStringToClipboard(str) {
    // Create new element
    var el = document.createElement('textarea');
    // Set value (string to be copied)
    el.value = str;
    // Set non-editable to avoid focus and move outside of view
    el.setAttribute('readonly', '');
    el.style = { position: 'absolute', left: '-9999px' };
    document.body.appendChild(el);
    // Select text inside element
    el.select();
    // Copy text to clipboard
    document.execCommand('copy');
    // Remove temporary element
    document.body.removeChild(el);
}

function otb_js_function_main() {

    /* Get the text field */
    var copyText = document.getElementById("myInput");

    copyStringToClipboard(copyText.value);

    /* Alert the copied text */
    alert("Shortcode copied to the clipboard");
}

function otb_js_function_gen() {

    /* Get the text field */
    var shortcodeHeight = document.getElementById("shortcodeHeight");
    var shortcodeWidth = document.getElementById("shortcodeWidth");

    var shortCode = `[oganro_flight_booking width='${shortcodeWidth.value}' height='${shortcodeHeight.value}']`;

    // pass to copt the code to otb_js_copy_function
    // otb_js_copy_function(shortCode);
    copyStringToClipboard(shortCode);

    /* Alert the copied text */
    alert("Customized Shortcode copied to the clipboard");

}

