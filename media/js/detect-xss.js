$(document).ready(function (e) {
    function t(e, t) {
        e.target.value = t.replace(/<[^>]*(s|S)(c|C)(r|R)(i|I)(p|P)(t|T).*>|<[^>]*(i|I)(f|F)(r|R)(a|A)(m|M)(e|E).*>|<[^>]*(i|I)(m|M)(g|G)( src="[a-z]*")?\s*>/g, "");
        e.target.value = e.target.value.replace(/\"/g, "'");
    }
    $("input,textarea").keypress(function (e) {
        13 == e.which && t(e, e.target.value);
    }),
        $("input,textarea").blur(function (e) {
            e.preventDefault(), t(e, e.target.value);
        });
});
function decodeHTMLEntities(text) {
    var entities = [
        ['amp', '&'],
        ['apos', '\''],
        ['#x27', '\''],
        ['#x2F', '/'],
        ['#39', '\''],
        ['#47', '/'],
        ['lt', '<'],
        ['gt', '>'],
        ['nbsp', ' '],
        ['quot', '"']
    ];

    for (var i = 0, max = entities.length; i < max; ++i)
        text = text.replace(new RegExp('&' + entities[i][0] + ';', 'g'), entities[i][1]);

    return text;
}