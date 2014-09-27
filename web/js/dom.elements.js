/**
 * Created by Mihail Kornilov on 28.09.2014.
 */

function DropList(name) {
    this.name = name;

    var tagged = function(text, tag, options) {
        tag = tag || 'option';
        options = options || '';

        return '<' + tag + ' ' + options + '>' + text + '</' + tag + '>';
    }

    this.getContent = function() {
        return tagged(content, 'select', 'name="' + this.name + '"');
    };

    var content = '';

    this.addElement = function(value, text, selected) {
        selected = selected || false;

        content += tagged(
            text,
            'option',
            'value="' + value + '"' + (selected) ? ' selected' : ''
        );
    }
};
