jQuery(document).ready(function ($) {
    mediaCat = $('#in-category-22');

    subCatList = $('li.child');
    parentCatInput = $('li.parent input[type="checkbox"]');
    parentCatLi = $('li.parent');
    subCatInput = $('li.child input[type="checkbox"]');

    parentCatInput.change(function(e){
        target = $(e.target);
        val = target.val();

        parentCatInput.prop('checked', false);
        target.prop('checked', true);
        parentCatLi.removeClass('selected');
        target.parents('li').addClass('selected');
        
        checked = mediaCat.is(':checked');
        toggleSubCats(checked);
    })


    toggleSubCats(mediaCat.is(':checked'));
    // subCatInput.is('checked') ? subCatInput.parents('li').addClass('selected');

    function toggleSubCats(checked){
        console.log('triggered:', checked);
        if(checked) {
            subCatList.removeClass('hidden');
        }
        else {
            subCatInput.prop('checked', false);
            subCatList.addClass('hidden');
        }
    }
})