jQuery(document).ready(function ($) {
    mediaCat = $('#in-category-22');

    subCatList = $('li.child');
    parentCatInput = $('li.parent input[type="checkbox"]');
    parentCatLi = $('li.parent');
    subCatInput = $('li.child input[type="checkbox"]');

    parentCatInput.change(function(e){
        target = $(e.target);
        toggleCats(target);
    })

    target = $('li.parent input[type="checkbox"]:checked');
    toggleCats(target);

    function toggleCats(target) {
        val = target.val();
        child = target.data('child') || false;
        console.log(child);

        parentCatInput.prop('checked', false);
        target.prop('checked', true);
        parentCatLi.removeClass('selected');
        target.parents('li').addClass('selected');

        if (child) {
            array = child.split(',');
            children = $(array);
            children.each(function () {
                $('#category-' + this).removeClass('hidden');
            })
        }
        else {
            subCatInput.prop('checked', false);
            subCatList.addClass('hidden');
        }
    };
   
})