var id;

$(() => {
    const meta = 'meta[name="item-info"]';
    id = parseInt($(meta).attr('data-id'));

    $('#openCrateButton').click(function() {
        $('#unboxItems').html('');

        $.post('/api/catalog/open-crate', { _token, id }).done(function(data) {
            if (typeof data.error !== 'undefined')
                return window.alert(data.error);

            const copiesOwned = parseInt($('#copiesOwned').html().replace(' owned', '')) - 1;

            $('#copiesOwned').text(`${copiesOwned} owned`);

            if (copiesOwned <= 0) {
                $('#ownershipCheck').hide();
                $('#openCrateButton').hide();
                $('#copiesOwned').hide();
            } else {
                $('#ownershipCheck').show();
                $('#openCrateButton').show();
                $('#copiesOwned').show();
            }

            $.each(data.unboxing_images, function() {
                $('#unboxItems').append(`
                <div class="crate-item">
                    <img style="border-bottom:3px solid ${this.color};padding:${this.padding};" src="${this.src}">
                </div>`);
            });

            $('#unbox').modal('show');
            $('.crate-item').animate({ left: data.animate_left }, 3000, 'easeOutQuad');

            setTimeout(() => {
                $('#prizeImage').attr('src', data.thumbnail).css('padding', data.padding);
                $('#prizeName').text(data.name);
                $('#unbox').modal('hide');
                $('#unbox').on('hidden.bs.modal', () => $('#prize').modal('show'));
            }, 3100);
        }).fail(() => window.alert('An unexpected error has occurred opening the crate. Your crate has been preserved, please try again. We apologize.'));
    });
});
