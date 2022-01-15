$(document).ready(function () {
    $('span.short').each(function (index, element) {
        var text = $(element).text();
        var limit = $(this).data('short') ?? 20;
        var short = text.length > limit ? text.substring(0, limit) : text;
        var moreBtn = `<a href="#" class="moreBtn" data-text="${text}"> (...)</a>`;

        const html = text.length > limit ? short + moreBtn : short;
        // Shorting element
        $(element).html(html);
    });

    // Trigger default
    $('span.short').on('click', 'a.moreBtn', function (e) {
        e.preventDefault()
        const text = $(this).data('text');
        const lessBtn = `<a href="#" class="lessBtn" data-text="${text}"> ...less</a>`;
        $(this).parent().html(text + lessBtn);
    });

    // Trigger short
    $('span.short').on('click', 'a.lessBtn', function (e) {
        e.preventDefault()
        var text = $(this).data('text');
        var limit = $(this).parent().data('short') ?? 20;
        var short = text.length > limit ? text.substring(0, limit) : text;
        const moreBtn = `<a href="#" class="moreBtn" data-text="${text}"> (...)</a>`;
        const html = text.length > limit ? short + moreBtn : short;
        $(this).parent().html(html);
    });


    // File size
    $(':file').change(function () {
        const size = (this.files[0].size / 1000) + ' kb';
        $('#size').text(size);
    });

    // Toogle sidebar device
    if (screen.width >= 992) $('#sidebar').addClass('active');
});