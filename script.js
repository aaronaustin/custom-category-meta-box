jQuery(document).ready(function ($) {
    catInputs = $('#custom-category li input[type="radio"]');

    mediaCat = $('[data-catslug="media"]');

    mediaTaxonomy = $('#media_category_div');
    mediaInputs = $('input[name="tax_input[media][]"]');
    

    toggleCats(
        triggerCat('media').prop('checked'), 
        taxDiv('media'), 
        targetInputs('media')
    );
    toggleCats(
        triggerCat('slide').prop('checked'),
        taxDiv('slide'), 
        targetInputs('slide')
    );

    catInputs.change(function(e){
        target = $(e.target);
        toggleCats(isInCat(target, 'media'), taxDiv('media'), targetInputs('media'));
    })
    catInputs.change(function(e){
        target = $(e.target);
        toggleCats(isInCat(target, 'slide'), taxDiv('slide'), targetInputs('slide'));
    })

    function triggerCat(slug) {
        return $('[data-catslug="' + slug + '"]');
    }
    function taxDiv(slug){
        return $('#' + slug + '_category_div');
    }
    function targetInputs(slug){
        return $('input[name="tax_input[' + slug + '][]"]');
    }
    function isInCat(element, slug) {
        return element.data('catslug') === slug;
    }
    function toggleCats(isInCat, taxonomy, inputs) {
        if(isInCat) {
            taxonomy.removeClass('hidden');
        }
        else {
            taxonomy.addClass('hidden');
            inputs.prop('checked', false);
        }
    }
   
})