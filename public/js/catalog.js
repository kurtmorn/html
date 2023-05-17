var currentCategory;
var currentSearch = '';
var currentSort = 'recent';
var currentCreator = '';
var itemTypesWithPadding = [];
var itemTypePadding = '0px';

$(() => {
    itemTypePadding = $('meta[name="item-type-padding-amount"]').attr('content');
    itemTypesWithPadding = JSON.parse($('meta[name="item-types-with-padding"]').attr('content'));

    $('#search').submit(function(event) {
        event.preventDefault();

        var oldSearch = currentSearch;
        currentSearch = $(this).find('input').val();

        if (currentSearch != oldSearch)
            search(currentCategory, 1, currentSearch);
    });

    $('#creator').submit(function(event) {
        event.preventDefault();

        var oldCreator = currentCreator;
        currentCreator = $(this).find('input').val();

        if (currentCreator != oldCreator)
            search(currentCategory, 1, currentSearch);
    });

    $('#sort').change(function() {
        currentSort = this.value;
        search(currentCategory, 1, currentSearch);
    });

    $('[data-toggle="collapse"]').click(function() {
        const collapsed = $(this).find('.indicator').text() == '+';
        $(this).find('.indicator').text((collapsed) ? '-' : '+');
    });

    $('[data-category]').click(function() {
        var oldCategory = currentCategory;

        $(`[data-category="${currentCategory}"]`).removeClass('active');
        $(this).addClass('active');

        currentCategory = $(this).attr('data-category');

        if (currentCategory != oldCategory)
            search(currentCategory, 1, currentSearch);
    });
});

function search(category, page, search)
{
    $.get('/api/catalog/search', { category, page, search, sort: currentSort, creator: currentCreator, list24: true }).done((data) => {
        $('#items').html('');
        $(`[data-category='${currentCategory}']`).removeClass('active');

        currentCategory = category;
        currentSearch = search;

        $(`[data-category='${currentCategory}']`).addClass('active');

        if (typeof data.error !== 'undefined')
            return $('#items').html(`<div class="col">${data.error}</div>`);

        $.each(data.items, function() {
            var header = '';
            var price = `<span><i class="currency"></i> ${this.price}</span>`;

            if (this.onsale && this.price == 0)
                price = `<span class="text-success">Free</span>`;
            else if (!this.onsale)
                price = `<span class="text-muted">Off Sale</span>`;

            if (this.limited) {
                header = `
                <div class="bg-warning text-white text-center" style="border-radius:50%;width:30px;height:30px;position:absolute;margin-left:5px;margin-top:5px;">
                    <div style="font-size:18px;font-weight:600;margin-top:3.5px;"><i class="fas fa-stars"></i></div>
                </div>`;
            } else if (this.timed) {
                header = `
                <div class="bg-danger text-white text-center" style="border-radius:50%;width:30px;height:30px;position:absolute;margin-left:5px;margin-top:5px;">
                    <span style="font-size:17px;font-weight:600;"><i class="fas fa-clock" style="margin-top:6.5px;"></i></span>
                </div>`;
            }

            $('#items').append(`
            <div class="col-6 col-md-2">
                <div class="card">
                    <div class="card-body" style="padding:10px;">
                        <a href="${this.url}">
                            ${header}
                            <img src="${this.thumbnail}">
                        </a>
                        <hr style="margin-bottom:5px;">
                        <div class="text-truncate">
                            <a href="${this.url}" style="color:inherit;font-weight:600;">${this.name}</a>
                            <div class="text-muted" style="font-size:14px;font-weight:500;margin-top:-4px;">By <a href="${this.creator.url}">${this.creator.username}</a></div>
                        </div>
                        <div style="font-weight:500;margin-top:-2px;">${price}</div>
                    </div>
                </div>
            </div>`);
        });

        $('[data-toggle="tooltip"]').tooltip();

        if (data.total_pages > 1) {
            const previousDisabled = (data.current_page == 1) ? 'disabled' : '';
            const nextDisabled = (data.current_page == data.total_pages) ? 'disabled' : '';
            const previousPage = data.current_page - 1;
            const nextPage = data.current_page + 1;

            $('#items').append(`
            <div class="col-12 text-center">
                <button class="btn btn-sm btn-danger" onclick="search('${currentCategory}', ${previousPage}, '${currentSearch}')" ${previousDisabled}>&laquo;</button>
                <span class="text-muted ml-2 mr-2">${data.current_page} of ${data.total_pages}</span>
                <button class="btn btn-sm btn-success" onclick="search('${currentCategory}', ${nextPage}, '${currentSearch}')" ${nextDisabled}>&raquo;</button>
            </div>`);
        }
    }).fail(() => $('#items').html('<div class="col">Unable to get items.</div>'));;
}