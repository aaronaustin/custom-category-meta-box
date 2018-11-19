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
    
    toggleMetaBox(triggerCat('event').prop('checked'), 'event_sectionid');

    catInputs.change(function(e){
        target = $(e.target);
        toggleCats(isInCat(target, 'media'), taxDiv('media'), targetInputs('media'));
        toggleMetaBox(isInCat(target, 'event'), 'event_sectionid');
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
    function toggleMetaBox(isInCat, divId) {
        console.log('toggle meta:', divId)
        if(isInCat) {
            $('#' + divId).removeClass('hidden');
        }
        else {
            $('#' + divId).addClass('hidden');
        }
    }


    //event data
    
    var eventNull = isEventValueNull('#event_start_date');


    $(".event_start").change(function(){
        eventCompDate('#event_start_date', '#event_start_time', '#event_start_datetime');
        var monthday = $('#event_start_date').val().slice(0, -3).replace('-', '');
        $('#event_monthday').val(monthday);
    });
    $(".event_end").change(function(){
        eventCompDate('#event_end_date', '#event_end_time', '#event_end_datetime');
    });

    function eventCompDate(date, time, target) {
        console.log(date);
        var sDate = $(date).val();
        var sTime = $(time).val();
        $(target).val(sDate + "T" + sTime);
        
        if(date == '#event_start_date' && eventNull) {
            console.log(sDate)
            $('#event_end_date').val(sDate);
            // eventNull = isEventValueNull('#event_end_date');
        }
    }

    function isEventValueNull(target){
        return $(target).val() ? false : true;
    }
   
})