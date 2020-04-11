jQuery(document).ready(function($) {
    $('.cball').click(function() {
        $('input:checkbox').not(this).prop('checked',this.checked);
        if( $('.d-style').hasClass('bgc-h-default-l3') && $(this).is(':checked')) {
            $('.d-style').removeClass('bgc-h-default-l3');
            $('.d-style').addClass('active bgc-yellow-l3');
            $('.select-display').attr('name','display[]');
            $('.ordering').attr('name','ordering[]');
        } else {
            $('.d-style').removeClass('active bgc-yellow-l3');
            $('.d-style').addClass('bgc-h-default-l3');
            $('.select-display').removeAttr('name');
            $('.ordering').removeAttr('name');
        }
    });
    $('.cbsingle').click(function() {
        if($(this).is(':checked')) {
            $(this).parents('.d-style').removeClass('bgc-h-default-l3');
            $(this).parents('.d-style').addClass('active bgc-yellow-l3');
            $(this).parents('.d-style').find('.select-display').attr('name','display[]');
            $(this).parents('.d-style').find('.ordering').attr('name','ordering[]');
        } else {
            $(this).parents('.d-style').removeClass('active bgc-yellow-l');
            $(this).parents('.d-style').addClass('bgc-h-default-l3');
            $(this).parents('.d-style').find('.select-display').removeAttr('name');
            $(this).parents('.d-style').find('.ordering').removeAttr('name');
        }
    });
    $('#search_filter').click(function() {
        var field = $('#search_field').val();
        var val = $('#search_value').val();
        if(val == '') {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Pls Enter Your Keywords...',
                showConfirmButton: false,
                timer: 1500
            })
            return;
        } else {
            let params 		= ['filter_status','filter_category','filter_tag'];
            let pathname = window.location.pathname;
            let link = getUrlParams(params);
            window.location.href = pathname + '?' + link + 'search_field=' + field + '&search_value=' + val; 
        }
    });

    $('.filter-term').click(function() {
        var filter_category = $('#filter_category').val();
        var filter_tag = $('#filter_tag').val();
        let params 		= ['filter_status','search_field','search_value'];
        let pathname = window.location.pathname;
        let link = getUrlParams(params);
        window.location.href = pathname + '?' + link + 'filter_category=' + filter_category + '&filter_tag=' + filter_tag;
        
    });
    $('.filter-showdisplay').click(function() {
        var filter_ishome = $('#filter_ishome').val();
        var filter_display = $('#filter_display').val();
        let params 		= ['filter_status','search_field','search_value'];
        let pathname = window.location.pathname;
        let link = getUrlParams(params);
        window.location.href = pathname + '?' + link + 'filter_ishome=' + filter_ishome + '&filter_display=' + filter_display;
    });

    $('#bulkaction').change(function() {
        var link = $(this).val();
        if(link != '') {
            console.log(1244);
            $('#bulk').removeAttr('disabled');
            $('#form-tbl').attr('action',link);
        } else {
            $('#bulk').attr('disabled','disabled');
            $('#form-tbl').attr('action','');
        }
    });
    $('#bulk').click(function() {
       if(testCheckbox() == false) {
            Swal.fire({
                position: 'top-start',
                icon: 'error',
                title: 'Pls choose the box...',
                showConfirmButton: false,
                timer: 1500,
            })
       } else {
            $('#form-tbl').submit();
       }
    });
    $('.delete-action').click(function(e) {
        e.preventDefault();
        var link = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                window.location.href = link;
            }
        })
    });
    
    
    // $('#upload-thumb').click(function() {
    //     $('#fileUpload').trigger('click'); 
    // })
})

function getUrlParams(params) {
    let searchParams = new URLSearchParams(window.location.search);
    let link = '';
    $.each(params, function(key,param) {
        if(searchParams.has(param)) {
            link += param + '=' + searchParams.get(param) + '&';
        }
    });
    return link;
}

function testCheckbox() {
    var check = false;
    $('.cbsingle').each(function() {
        if($(this).is(':checked')) {
            check = true;   
            return;
        }
    })
    return check;
}

$('#summernote').summernote({
    height:400
});
$.extend($.summernote.options.icons ,  {
    'align': 'fa fa-align',
    'alignCenter': 'fa fa-align-center',
    'alignJustify': 'fa fa-align-justify'
});
