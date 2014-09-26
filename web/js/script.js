function softOutput(selector, text, freq) {
    var freq   = freq || 500;

    if (text.length < 2) {
        $(selector).text($(selector).text() + text);
        return;
    }

    for (var i = 0; i < text.length; ++i) {
        setTimeout(function() {
            $(selector).text($(selector).text() + text[i]);
        }, freq);
    }
    return;
}