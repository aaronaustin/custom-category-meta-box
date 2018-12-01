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
        triggerCat('worship').prop('checked'), 
        taxDiv('media'), 
        targetInputs('media')
    );
    toggleCats(
        triggerCat('slide').prop('checked'),
        taxDiv('slide'), 
        targetInputs('slide')
    );
    
    toggleMetaBox(triggerCat('event').prop('checked') || triggerCat('worship').prop('checked'), 'event_sectionid');
 
    catInputs.change(function(e){
        target = $(e.target);
        toggleCats(isInCat(target, ['media', 'worship']), taxDiv('media'), targetInputs('media'));
        toggleCats(isInCat(target, 'slide'), taxDiv('slide'), targetInputs('slide'));
        toggleMetaBox(isInCat(target, ['event', 'worship']), 'event_sectionid');
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
        if (typeof slug === 'object'){            
            return slug.indexOf(element.data('catslug')) !== -1 ? true : false;
        }
        else {
            return element.data('catslug') === slug;
        }
    }
    function toggleCats(isInCat, taxonomy, inputs) {
        if(isInCat) {
            taxonomy.show();
        }
        else {
            taxonomy.hide();
            // inputs.prop('checked', false);
        }
    }
    function toggleMetaBox(isInCat, divId) {
        console.log('toggle meta:', divId)
        if(isInCat) {
            $('#' + divId).show();
        }
        else {
            $('#' + divId).hide();
        }
    }


    //EVENT DATA
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
        var sDate = $(date).val();
        var sTime = $(time).val();
        
        if(date == '#event_start_date') {
            console.log(sDate)
            $('#event_end_date').attr('value', sDate);
            if(!sTime) {
                $('#event_start_time').attr('value','18:00');
                $('#event_end_time').attr('value','19:00');
            }
            else {        
                var newhours = (Number(sTime.substring(0,2)) + 1) + sTime.substring(2,5);
                console.log(newhours)
                $('#event_end_time').attr('value',newhours);
            }
        }
        sDate = $('#event_start_date').val();
        sTime = $('#event_start_time').val();
        eDate = $('#event_end_date').val();
        eTime = $('#event_end_time').val();
        $('#event_start_datetime').attr('value', sDate + "T" + sTime);
        $('#event_end_datetime').attr('value', eDate + "T" + eTime);
    }
    function isEventValueNull(target){
        return $(target).val() ? false : true;
    }

    var eventDefaultLocation = {
       'location' : 'Central Baptist Church',
       'address' : '110 Wilson Downing Rd.',
       'city' : 'Lexington',
       'state' : 'KY',
       'zip' : '40517',
    };


    $('#setDefault').click(function(e){
        e.preventDefault();
        setDefaultLocation();
    })

    function setDefaultLocation() {
        $('#event_location').val(eventDefaultLocation.location);
        $('#event_address').val(eventDefaultLocation.address);
        $('#event_city').val(eventDefaultLocation.city);
        $('#event_state').val(eventDefaultLocation.state);
        $('#event_zip').val(eventDefaultLocation.zip);
    }
   
})