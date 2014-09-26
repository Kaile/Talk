function softOutput(selector, text, freq) {
    var freq   = freq || 100;

    if (text.length < 2) {
        $(selector).text(text);
        return;
    }

    for (var i = 0; i < text.length; ++i) {
        setTimeout(function() {
            $(selector).append(text[i]);
        }, freq);
    }
    return;
}