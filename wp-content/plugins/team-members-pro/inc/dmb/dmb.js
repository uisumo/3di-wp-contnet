/**
 * Team Members Admin JS
 */

;(function($){
$(document).ready(function (){

  /* Debounce function for fallback keyup. */
  // http://davidwalsh.name/javascript-debounce-function
  function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
  };

  /* Equalizes each member on the page. */
  function tmm_equalize(){

    /* Preparing social icon. */
    $('.tmm_textblock').css({'padding-bottom' : '10px'});

    $('.tmm_scblock').each(function(i, val){
      if ($(this).html().length > 0) {
        $(this).closest('.tmm_textblock').css({'padding-bottom' : '65px'});
      }
    });

    /* Equalizer. */
    $('.tmm_container').each(function(){

      if($(this).hasClass('tmm-equalizer')){

        var current_container = $(this);
        var members = [];

        var tabletCount = 0;
        var tabletArray = [];
        var memberOne;
        var memberOneHeight;
        var memberTwo;
        var memberTwoHeight;

        current_container.find('.tmm_member').each(function(){

          tabletCount++;

          var current_member = $(this);
          current_member.css({'min-height':0});
          members.push(current_member.outerHeight());

          if (tabletCount == 1) {
            memberOne = current_member;
            memberOneHeight = memberOne.outerHeight();
          } else if (tabletCount == 2) { 
            tabletCount = 0;
            memberTwo = current_member;
            memberTwoHeight = memberTwo.outerHeight();

            if (memberOneHeight >= memberTwoHeight) {
              tabletArray.push({
                memberOne: memberOne,
                memberTwo: memberTwo,
                height: memberOneHeight
              });
            } else {
              tabletArray.push({
                memberOne: memberOne,
                memberTwo: memberTwo,
                height: memberTwoHeight
              });
            }

          }

        });

        if(parseInt($( window ).width()) > 1026){

          biggestMember = Math.max.apply(Math, members);
          current_container.find('.tmm_member').css('min-height', biggestMember);

        } else if (parseInt($( window ).width()) > 640) {

          $.each( tabletArray, function( index, value ){
            $(value.memberOne).css('min-height', value.height);
            $(value.memberTwo).css('min-height', value.height);
          });

        } else {

          current_container.find('.tmm_member').css('min-height', 'auto');

        }

      }

    });

    

  }

  /* Triggers equalizer on resize. */
  $( window ).resize( debounce(function() { tmm_equalize(); }, 100));


  /* Spencer Tipping jQuery's clone method fix (for select fields). */
  (function (original) {
    jQuery.fn.clone = function () {
      var result           = original.apply(this, arguments),
          my_textareas     = this.find('textarea').add(this.filter('textarea')),
          result_textareas = result.find('textarea').add(result.filter('textarea')),
          my_selects       = this.find('select').add(this.filter('select')),
          result_selects   = result.find('select').add(result.filter('select'));
  
      for (var i = 0, l = my_textareas.length; i < l; ++i) $(result_textareas[i]).val($(my_textareas[i]).val());
      for (var i = 0, l = my_selects.length;   i < l; ++i) result_selects[i].selectedIndex = my_selects[i].selectedIndex;
  
      return result;
    };
  }) (jQuery.fn.clone);


  /* Defines folder slug. */
  var pluginFolderSlug = 'team-members-pro';
  

  /* Color conversions. */
  var hexDigits = new Array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
  function dmb_rgb2hex(rgb) {
    if (rgb) {
      rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
      return "#" + dmb_hex(rgb[1]) + dmb_hex(rgb[2]) + dmb_hex(rgb[3]);
    } else {
      return;
    }
  }
  function dmb_hex(x) {
    return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
  } 


  /* Inits color pickers. */
  $('.dmb_color_picker').each(function(i, obj){$(this).wpColorPicker();});


  /* Adapts UI to user settings. */
  function checkSettingsUI() {
    var currentLayout = $("select[name='team_picture_position'] option:selected").val();
    if(currentLayout == 'full'){
      $(".dmb_picture_shape_box").hide();
      $(".dmb_picture_border_box").hide();
    } else {
      $(".dmb_picture_shape_box").show();
      $(".dmb_picture_border_box").show();
    }
  }
  
  checkSettingsUI();

  /* Defines trigger for UI update. */
  $('body').on('change', '.dmb_layout_select', function(e) { checkSettingsUI(); });


  /* Gathers data into single input. */
  function dmbGatherData(keyUpParam) {
    
    var member = keyUpParam.closest('.dmb_main'),

    firstname = member.find('.dmb_firstname_of_member').val() || '',
    lastname = member.find('.dmb_lastname_of_member').val() || '',
    job = member.find('.dmb_job_of_member').val() || '';

    if ($('#acf-fallback-bio').length ) {
      description = $.trim(member.find('.dmb_description_of_member_fb').text()) || '';
    } else {
      description = $.trim(member.find('.dmb_description_of_member').html()) || '';
    }

    var sclType1 = member.find('.dmb_scl_type1_of_member').val() || '',
    sclTitle1 = member.find('.dmb_scl_title1_of_member').val() || '',
    sclUrl1 = member.find('.dmb_scl_url1_of_member').val() || '',

    sclType2 = member.find('.dmb_scl_type2_of_member').val() || '',
    sclTitle2 = member.find('.dmb_scl_title2_of_member').val() || '',
    sclUrl2 = member.find('.dmb_scl_url2_of_member').val() || '',

    sclType3 = member.find('.dmb_scl_type3_of_member').val() || '',
    sclTitle3 = member.find('.dmb_scl_title3_of_member').val() || '',
    sclUrl3 = member.find('.dmb_scl_url3_of_member').val() || '',

    sclType4 = member.find('.dmb_scl_type4_of_member').val() || '',
    sclTitle4 = member.find('.dmb_scl_title4_of_member').val() || '',
    sclUrl4 = member.find('.dmb_scl_url4_of_member').val() || '',

    sclType5 = member.find('.dmb_scl_type5_of_member').val() || '',
    sclTitle5 = member.find('.dmb_scl_title5_of_member').val() || '',
    sclUrl5 = member.find('.dmb_scl_url5_of_member').val() || '',

    memberPhoto = member.find('.dmb_photo_of_member').attr('data-img') || '',
    memberPhotoUrl = member.find('.dmb_photo_url_of_member').val() || '',

    compTitle = member.find('.dmb_comp_title_of_member').val() || '',
    compText = member.find('.dmb_comp_text_of_member').val() || '',

    hoverPhoto = member.find('.dmb_hover_photo_of_member').attr('data-img') || '',

    memberColor = dmb_rgb2hex(member.find(".wp-color-result").css('backgroundColor')) || '#8dba09',

    hide;
    if (member.find('.dmb_hide_of_member').is(':checked'))  {
      hide = '1';
    } else {
      hide = '0';
    }

    /* Finds single input. */
    dataDump = member.find('.dmb_data_dump');

    /* Fills single input. */
    dataDump.val(
      firstname + ']--[' + 
      lastname + ']--[' + 
      job + ']--[' +
      description + ']--[' +
      sclType1 + ']--[' +
      sclTitle1 + ']--[' +
      sclUrl1 + ']--[' +
      sclType2 + ']--[' +
      sclTitle2 + ']--[' +
      sclUrl2 + ']--[' +
      sclType3 + ']--[' +
      sclTitle3 + ']--[' +
      sclUrl3 + ']--[' +
      sclType4 + ']--[' +
      sclTitle4 + ']--[' +
      sclUrl4 + ']--[' +
      sclType5 + ']--[' +
      sclTitle5 + ']--[' +
      sclUrl5 + ']--[' +
      memberPhoto + ']--[' +
      memberPhotoUrl + ']--[' +
      compTitle + ']--[' +
      compText + ']--[' +
      hoverPhoto + ']--[' +
      memberColor + ']--[' +
      hide
    );
  }


  /* Defines trigger for single input update. */
  $('body').on('keyup', '.dmb_field', function(e) { dmbGatherData($(this)); });

  $('body').on('change', '.dmb_scl_type_select', function(e) { dmbGatherData($(this)); });
  
  $('body').on('change', '.dmb_img_data_url', function(e) { dmbGatherData($(this)); });

  $('body').on('change', '.dmb_hide_of_member', function(e) { dmbGatherData($(this)); });


  /* Add change event to all pickers. */
  function refreshPickerChangeEvents() {
      $('.wp-color-picker').wpColorPicker( 'option','change', function(event, ui) { dmbGatherData($(this)); });
  } 

  refreshPickerChangeEvents();

  
  /* Shows img/remove button if exists on page load. */
  $('.dmb_img_data_url').each(function(i, obj) {
    var imgUrl = $(this).attr("data-img");
    if (imgUrl != ''){
      $("<a class='dmb_remove_img_btn dmb_button dmb_button_large dmb_button_compact' href='#'><span class='dashicons dashicons-trash'></span></a><img src='"+imgUrl+"' class='dmb_img'/>").insertAfter($(this).parent().find('.dmb_upload_img_btn'));
    }
  });


  /* Processes member's description fields. */
  /* Initial single input update. */
  $('.dmb_main').not('.dmb_empty_row').each(function(i, obj){

    $(this).find('.dmb_description_of_member').each(function(i, obj){
      if ($.trim($(this).text()) == ''){
        $(this).hide();
      } else {
        $(this).show();
      }
      $(this).html($.parseHTML($(this).text())); 
    });

    /* Triggers single input update. */
    dmbGatherData($(this).find('.dmb_field').first());

  });


  /* Shows/hides no row notice. */
  function refreshRowCountRelatedUI(){
    /* Shows notice when team has no member. */
    if($('.dmb_main').not('.dmb_empty_row').length > 0){
      $( '.dmb_no_row_notice' ).hide();
    } else {
      $( '.dmb_no_row_notice' ).show();
    }
  }

  refreshRowCountRelatedUI();


  /* Removes member's img. */
  $('body').on('click', '.dmb_remove_img_btn', function(e) {

    $(this).parent().find('.dmb_img').remove();

    /* Empties img URL (primary or hover). */
    $(this)
      .parent()
      .find('.dmb_img_data_url')
      .attr('data-img', '')
      .trigger('change');

    $(this).remove();

    return false;

  });


  /* Uploads members's img. */
  $('.dmb_upload_img_btn').click(function(e) {

    e.preventDefault();
 
    		var button = $(this),
    		    custom_uploader = wp.media({
			title: 'Insert image',
			library : {
				// uncomment the next line if you want to attach image to the current post
				// uploadedTo : wp.media.view.settings.post.id, 
				type : 'image'
			},
			button: {
				text: 'Use this image' // button label text
			},
			multiple: false // for multiple image selection set to true
		}).on('select', function() { // it also has "open" and "close" events 
			var attachment = custom_uploader.state().get('selection').first().toJSON();
      button.siblings('img, .dmb_remove_img_btn, .dashicons-trash').remove();
      $("<a class='dmb_remove_img_btn dmb_button dmb_button_large dmb_button_compact' href='#'><span class='dashicons dashicons-trash'></span></a><img src='"+attachment.url+"' class='dmb_img'/>").insertAfter(button);
      button.siblings('.dmb_img_data_url').attr('data-img', attachment.url).trigger('change');
    })
		.open();

  });


  /* Adds a member to the team. */
  $( '.dmb_add_row' ).on('click', function() {

    /* Clones/cleans/displays the empty row. */
    var row = $( '.dmb_empty_row' ).clone(true);
    row.removeClass( 'dmb_empty_row' ).addClass('dmb_main').show();
    row.insertBefore( $('.dmb_empty_row') );

    row.find('.dmb_firstname_of_member').focus();
   
    /* Inits color picker. */
    row.find('.dmb_color_picker_ready').removeClass('.dmb_color_picker_ready').addClass('.dmb_color_picker').wpColorPicker().css({'padding':'3px'});

    refreshPickerChangeEvents();

    /* Defaults handle title. */
    row.find('.dmb_handle_title').html(objectL10n.untitled);
    
    /* Hides empty member description. */
    row.find('.dmb_description_of_member').hide();
    
    refreshRowCountRelatedUI();
    return false;

  });


  /* Removes a row. */
  $('.dmb_remove_row_btn').click(function(e) {
    
    $(this).closest('.dmb_main').remove();
    
    refreshRowCountRelatedUI();
    return false;

  });


  /* Expands/collapses handle. */
  $('.dmb_handle').click(function(e) {

    $(this).siblings('.dmb_inner').slideToggle(50);

    ($(this).hasClass('closed')) 
      ? $(this).removeClass('closed') 
      : $(this).addClass('closed');

    return false;

  });


  /* Collapses all rows. */
  $('.dmb_collapse_rows').click(function(e) {

    $('.dmb_handle').each(function(i, obj){
      if(!$(this).closest('.dmb_empty_row').length){ // Makes sure not to collapse empty row.
        if($(this).hasClass('closed')){

        } else {

          $(this).siblings('.dmb_inner').slideToggle(50);
          $(this).addClass('closed');

        }
      }
    });

    return false;

  });


  /* Expands all rows. */
  $('.dmb_expand_rows').click(function(e) {

    $('.dmb_handle').each(function(i, obj){
      if($(this).hasClass('closed')){

        $(this).siblings('.dmb_inner').slideToggle(50);
        $(this).removeClass('closed');

      }
    });

    return false;

  });


  /* Shifts a row down (clones and deletes). */
  $('.dmb_move_row_down').click(function(e) {

    if($(this).closest('.dmb_main').next().hasClass('dmb_main')){ // If there's a next row.
      /* Clones the row. */
      var movingRow = $(this).closest('.dmb_main').clone(true);
      /* Inserts it after next row. */
      movingRow.insertAfter($(this).closest('.dmb_main').next());

      /* Handles color picker travel. */
      var rgbColorToMove = $(this).closest('.dmb_main').find('.wp-color-result').css('backgroundColor');
      movingRow.find('.wp-picker-container').remove();
      movingRow.find('.dmb_color_box').append('<input class="dmb_color_picker dmb_field dmb_color_of_member" name="team_color" type="text" value="'+dmb_rgb2hex(rgbColorToMove)+'" />');
      movingRow.find('.dmb_color_picker').wpColorPicker();

      /* Removes original row. */
      $(this).closest('.dmb_main').remove();
    }

    return false;

  });


  /* Shifts a row up (clones and deletes). */
  $('.dmb_move_row_up').click(function(e) {

    if($(this).closest('.dmb_main').prev().hasClass('dmb_main')){ // If there's a previous row.
      /* Clones the row. */
      var movingRow = $(this).closest('.dmb_main').clone(true);
      /* Inserts it before previous row. */
      movingRow.insertBefore($(this).closest('.dmb_main').prev());

      /* Handles color picker travel. */
      var rgbColorToMove = $(this).closest('.dmb_main').find('.wp-color-result').css('backgroundColor');
      movingRow.find('.wp-picker-container').remove();
      movingRow.find('.dmb_color_box').append('<input class="dmb_color_picker dmb_field dmb_color_of_member" name="team_color" type="text" value="'+dmb_rgb2hex(rgbColorToMove)+'" />');
      movingRow.find('.dmb_color_picker').wpColorPicker();

      /* Removes original row. */
      $(this).closest('.dmb_main').remove();
    }

    return false;

  });


  /* Duplicates a row. */
  $('.dmb_clone_row').click(function(e) {

    /* Clones the row. */
    var clone = $(this).closest('.dmb_main').clone(true);
    /* Inserts it after original row. */
    clone.insertAfter($(this).closest('.dmb_main'));
    /* Adds 'copy' to title. */
    clone.find('.dmb_handle_title').html(clone.find('.dmb_firstname_of_member').val() + ' ('+objectL10n.copy+')');
    clone.find('.dmb_firstname_of_member').focus();
    
    /* Handles color picker travel. */
    var rgbColorToMove = $(this).closest('.dmb_main').find('.wp-color-result').css('backgroundColor');
    clone.find('.wp-picker-container').remove();
    clone.find('.dmb_color_box').append('<input class="dmb_color_picker dmb_field dmb_color_of_member" name="team_color" type="text" value="'+dmb_rgb2hex(rgbColorToMove)+'" />');
    clone.find('.dmb_color_picker').wpColorPicker();

    refreshPickerChangeEvents();

    updateHandleTitle(clone.find('.dmb_firstname_of_member'), true);
    refreshRowCountRelatedUI(); 
    return false;

  });


   /* Duplicates a row. */
   $('.dmb_export_row').click(function(e) {

    var member = $(this).closest('.dmb_main'),

    firstname = member.find('.dmb_firstname_of_member').val() || '',
    lastname = member.find('.dmb_lastname_of_member').val() || '',
    job = member.find('.dmb_job_of_member').val() || '';

    if ($('#acf-fallback-bio').length ) {
      description = $.trim(member.find('.dmb_description_of_member_fb').text()) || '';
    } else {
      description = $.trim(member.find('.dmb_description_of_member').html()) || '';
    }

    var sclType1 = member.find('.dmb_scl_type1_of_member').val() || '',
    sclTitle1 = member.find('.dmb_scl_title1_of_member').val() || '',
    sclUrl1 = member.find('.dmb_scl_url1_of_member').val() || '',

    sclType2 = member.find('.dmb_scl_type2_of_member').val() || '',
    sclTitle2 = member.find('.dmb_scl_title2_of_member').val() || '',
    sclUrl2 = member.find('.dmb_scl_url2_of_member').val() || '',

    sclType3 = member.find('.dmb_scl_type3_of_member').val() || '',
    sclTitle3 = member.find('.dmb_scl_title3_of_member').val() || '',
    sclUrl3 = member.find('.dmb_scl_url3_of_member').val() || '',

    sclType4 = member.find('.dmb_scl_type4_of_member').val() || '',
    sclTitle4 = member.find('.dmb_scl_title4_of_member').val() || '',
    sclUrl4 = member.find('.dmb_scl_url4_of_member').val() || '',

    sclType5 = member.find('.dmb_scl_type5_of_member').val() || '',
    sclTitle5 = member.find('.dmb_scl_title5_of_member').val() || '',
    sclUrl5 = member.find('.dmb_scl_url5_of_member').val() || '',

    memberPhoto = member.find('.dmb_photo_of_member').attr('data-img') || '',
    memberPhotoUrl = member.find('.dmb_photo_url_of_member').val() || '',

    compTitle = member.find('.dmb_comp_title_of_member').val() || '',
    compText = member.find('.dmb_comp_text_of_member').val() || '',

    hoverPhoto = member.find('.dmb_hover_photo_of_member').attr('data-img') || '',

    memberColor = dmb_rgb2hex(member.find(".wp-color-result").css('backgroundColor')) || '#8dba09',

    hide;
    if (member.find('.dmb_hide_of_member').is(':checked'))  {
      hide = '1';
    } else {
      hide = '0';
    }

    /* Finds single input. */
    var exportData = 
      encodeURIComponent(firstname) + ']--[' + 
      encodeURIComponent(lastname) + ']--[' + 
      encodeURIComponent(job) + ']--[' +
      encodeURIComponent(description) + ']--[' +
      encodeURIComponent(sclType1) + ']--[' +
      encodeURIComponent(sclTitle1) + ']--[' +
      encodeURIComponent(sclUrl1) + ']--[' +
      encodeURIComponent(sclType2) + ']--[' +
      encodeURIComponent(sclTitle2) + ']--[' +
      encodeURIComponent(sclUrl2) + ']--[' +
      encodeURIComponent(sclType3) + ']--[' +
      encodeURIComponent(sclTitle3) + ']--[' +
      encodeURIComponent(sclUrl3) + ']--[' +
      encodeURIComponent(sclType4) + ']--[' +
      encodeURIComponent(sclTitle4) + ']--[' +
      encodeURIComponent(sclUrl4) + ']--[' +
      encodeURIComponent(sclType5) + ']--[' +
      encodeURIComponent(sclTitle5) + ']--[' +
      encodeURIComponent(sclUrl5) + ']--[' +
      encodeURIComponent(memberPhoto) + ']--[' +
      encodeURIComponent(memberPhotoUrl) + ']--[' +
      encodeURIComponent(compTitle) + ']--[' +
      encodeURIComponent(compText) + ']--[' +
      encodeURIComponent(hoverPhoto) + ']--[' +
      encodeURIComponent(memberColor) + ']--[' +
      encodeURIComponent(hide);

    function download(filename, text) {
      var element = document.createElement('a');
      element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
      element.setAttribute('download', filename);
    
      element.style.display = 'none';
      document.body.appendChild(element);
    
      element.click();
    
      document.body.removeChild(element);
    }
    
    // Start file download.
    var filename =  firstname || "firstname";
    filename += '-';
    filename += lastname || "lastname";
    filename += '-dt.txt';
    download(filename, exportData );

    return false;

  });

  /* Extracting import file data. */
  if($('#dmb_import_row').length > 0) {
    var inputElement = document.getElementById("dmb_import_row");
    inputElement.addEventListener("change", handleFiles, false);
  }
  

  function handleFiles() {

    var file = this.files[0]; /* now you can work with the file list */
    var reader = new FileReader();

    reader.onload = function (e) {
      //get the file result, split by comma to remove the prefix, then base64 decode the contents
      var decodedText = atob(e.target.result.split(',')[1]);
      //show the file contents
      importMember(decodedText);
    };
    reader.readAsDataURL(file);

    reader.onloadend = function (e) {
      $('.dmb_import_row').val('');
    };

  }

  /* Import user. */
  function importMember(memberData){
    
    $member_data = memberData.split("]--[");
			
    $member_firstname = decodeURIComponent($member_data[0]);
    $member_lastname = decodeURIComponent($member_data[1]);
    $member_job = decodeURIComponent($member_data[2]);
    $member_bio = decodeURIComponent($member_data[3]);

    $member_scl_type1 = decodeURIComponent($member_data[4]);
    $member_scl_title1 = decodeURIComponent($member_data[5]);
    $member_scl_url1 = decodeURIComponent($member_data[6]);

    $member_scl_type2 = decodeURIComponent($member_data[7]);
    $member_scl_title2 = decodeURIComponent($member_data[8]);
    $member_scl_url2 = decodeURIComponent($member_data[9]);

    $member_scl_type3 = decodeURIComponent($member_data[10]);
    $member_scl_title3 = decodeURIComponent($member_data[11]);
    $member_scl_url3 = decodeURIComponent($member_data[12]);

    $member_scl_type4 = decodeURIComponent($member_data[13]);
    $member_scl_title4 = decodeURIComponent($member_data[14]);
    $member_scl_url4 = decodeURIComponent($member_data[15]);

    $member_scl_type5 = decodeURIComponent($member_data[16]);
    $member_scl_title5 = decodeURIComponent($member_data[17]);
    $member_scl_url5 = decodeURIComponent($member_data[18]);
    
    $member_photo = decodeURIComponent($member_data[19]);
    $member_photo_url = decodeURIComponent($member_data[20]);

    $member_comp_title = decodeURIComponent($member_data[21]);
    $member_comp_text = decodeURIComponent($member_data[22]);
    $member_hover_photo = decodeURIComponent($member_data[23]);
    $member_color = decodeURIComponent($member_data[24]);

    $member_hide = decodeURIComponent($member_data[25]);

    /* Clones/cleans/displays the empty row. */
    var row = $( '.dmb_empty_row' ).clone(true);
    row.removeClass( 'dmb_empty_row' ).addClass('dmb_main').show();
    row.insertBefore( $('.dmb_empty_row') );

    row.find('.dmb_firstname_of_member').val($member_firstname);
    row.find('.dmb_lastname_of_member').val($member_lastname);
    row.find('.dmb_job_of_member').val($member_job);

    if ($member_bio) {
      row.find('.dmb_description_of_member').html($member_bio);
    } else {
      /* Hides empty member description. */
      row.find('.dmb_description_of_member').hide();
    }

    row.find('.dmb_comp_text_of_member').val($member_comp_text);
    row.find('.dmb_comp_title_of_member').val($member_comp_title);
    
    row.find('.dmb_scl_type1_of_member option[value="'+$member_scl_type1+'"]').attr("selected", "selected");
    row.find('.dmb_scl_title1_of_member').val($member_scl_title1);
    row.find('.dmb_scl_url1_of_member').val($member_scl_url1);

    row.find('.dmb_scl_type2_of_member option[value="'+$member_scl_type2+'"]').attr("selected", "selected");
    row.find('.dmb_scl_title2_of_member').val($member_scl_title2);
    row.find('.dmb_scl_url2_of_member').val($member_scl_url2);

    row.find('.dmb_scl_type3_of_member option[value="'+$member_scl_type3+'"]').attr("selected", "selected");
    row.find('.dmb_scl_title3_of_member').val($member_scl_title3);
    row.find('.dmb_scl_url3_of_member').val($member_scl_url3);

    row.find('.dmb_scl_type4_of_member option[value="'+$member_scl_type4+'"]').attr("selected", "selected");
    row.find('.dmb_scl_title4_of_member').val($member_scl_title4);
    row.find('.dmb_scl_url4_of_member').val($member_scl_url4);

    row.find('.dmb_scl_type5_of_member option[value="'+$member_scl_type5+'"]').attr("selected", "selected");
    row.find('.dmb_scl_title5_of_member').val($member_scl_title5);
    row.find('.dmb_scl_url5_of_member').val($member_scl_url5);

    if($member_photo != ''){
      var imgButton = row.find('.dmb_upload_img_btn')[0];
      $("<a class='dmb_remove_img_btn dmb_button dmb_button_large dmb_button_compact' href='#'><span class='dashicons dashicons-trash'></span></a><img src='"+$member_photo+"' class='dmb_img'/>").insertAfter(imgButton);
      $(imgButton).siblings('.dmb_img_data_url').attr('data-img',$member_photo).trigger('change');
    }
    
    if($member_hover_photo != ''){
      var hoverImgButton = row.find('.dmb_upload_img_btn')[1];
      $("<a class='dmb_remove_img_btn dmb_button dmb_button_large dmb_button_compact' href='#'><span class='dashicons dashicons-trash'></span></a><img src='"+$member_hover_photo+"' class='dmb_img'/>").insertAfter(hoverImgButton);
      $(hoverImgButton).siblings('.dmb_img_data_url').attr('data-img',$member_hover_photo).trigger('change');
    }

    row.find('.dmb_photo_url_of_member').val($member_photo_url);

    /* Inits color picker. */
    var theColor = row.find('.dmb_color_picker_ready').removeClass('.dmb_color_picker_ready').addClass('.dmb_color_picker').wpColorPicker().css({'padding':'3px'});
    theColor.wpColorPicker('color', $member_color);
    refreshPickerChangeEvents();

    updateHandleTitle(row.find('.dmb_firstname_of_member'), 0, 1);

    dmbGatherData(row.find('.dmb_firstname_of_member'));

    refreshRowCountRelatedUI();
    return false;

  }


  /* Adds row title to handle. */
  $('.dmb_main').not('.dmb_empty_row').each(function(i, obj){

    if($(this).find('.dmb_firstname_of_member').val() != ''){
      
      var handleTitle = $(this).find('.dmb_handle_title'),
      firstname = $(this).find('.dmb_firstname_of_member').val(),
      lastname = $(this).find('.dmb_lastname_of_member').val();
      handleTitle.html(firstname + ' ' + lastname);

    }

  });


  /* Updates handle bar title. */
  function updateHandleTitle(firstnameField, wasCloned, wasImported) {

    if(!wasCloned) { wasCloned = false; }
    if(!wasImported) { wasImported = false; }
    
    /* Makes current title. */
    var firstnameField = firstnameField,
    lastname = firstnameField.closest('.dmb_main').find('.dmb_lastname_of_member').val() || '';
    handleTitle = firstnameField.closest('.dmb_main').find('.dmb_handle_title');
    var cloneCopyText = '';
    var importedText = '';
    (wasCloned) ? cloneCopyText = ' copy' : cloneCopyText = '';
    (wasImported) ? importedText = ' imported' : importedText = '';
    
    /* Updates handle title. */
    (firstnameField.val() != '')
      ? handleTitle.html(firstnameField.val() + ' ' + lastname + cloneCopyText + importedText)
      : handleTitle.html(objectL10n.untitled + cloneCopyText + importedText);
  
  }


  /* Watches member firstname/lastname and updates handle. */
  $('body').on('keyup', '.dmb_firstname_of_member', function(e) { updateHandleTitle($(this)); });
  $('body').on('keyup', '.dmb_lastname_of_member', function(e) {
    firstnameField = $(this).closest('.dmb_main').find('.dmb_firstname_of_member');
    updateHandleTitle(firstnameField);
  });


  /* Previews team. */
  $('.dmb_show_preview_team').click(function(){
    
    var settings = {};
    var team = {};
    var preview_html = '';
    var visibleMembers = [];

    settings.columns = $("select[name='team_columns'] option:selected").val();
    settings.bio_alignment = $("select[name='team_bio_align'] option:selected").val();
    settings.piclink_beh = $("select[name='team_piclink_beh'] option:selected").val();
    settings.piclink_beh == 'new' ? team.plb = 'target="_blank"' : team.plb = '';
    settings.picture_shape = $("select[name='team_picture_shape'] option:selected").val();
    settings.picture_border = $("select[name='team_picture_border'] option:selected").val();
    settings.picture_position = $("select[name='team_picture_position'] option:selected").val();
    settings.picture_filter = $("select[name='team_picture_filter'] option:selected").val();
    settings.tp_border_size = $(".dmb_tp_border_size_of_member").val();
    settings.comp_theme = $("select[name='team_comp_theme'] option:selected").val();
    settings.equalizer = $("select[name='team_equalizer'] option:selected").val();

    (settings.picture_position) ? team.picture_position = 'tmm-' + settings.picture_position + '-pic' : settings.picture_position = '';
    (settings.equalizer == 'yes') ? team.equalizer = 'tmm-equalizer' : team.equalizer = '';

    team.styling_classes = '';

    /* Counts the members. */
    team.memberCount = $('.dmb_main').not('.dmb_empty_row').length;
    
    /* Checks the PRO options */
    if (settings.picture_shape == 'square' || settings.picture_position == 'full') {
      team.styling_classes += 'tmm_squared-borders ';
    } else if (settings.picture_shape == 'circular') {
      team.styling_classes += 'tmm_circular-borders ';
    }

    if (settings.picture_border == 'no' || settings.picture_position == 'full')
      team.styling_classes += 'tmm_no-borders ';

    if (settings.picture_filter == 'vintage')
      team.styling_classes += 'tmm_filter-vintage ';

    if (settings.picture_filter == 'blackandwhite')
      team.styling_classes += 'tmm_filter-bandw ';

    if (settings.picture_filter == 'saturated')
      team.styling_classes += 'tmm_filter-saturated';

    /* Prepares the output. */
    preview_html += '<div class="tmm ' + team.picture_position + '" style="margin-top: 100px;">';
      preview_html += '<div class="tmm_' + settings.columns + '_columns tmm_wrap tmm_plugin_f">';

        /* Removes hidden members. */
        
        $('.dmb_main').not('.dmb_empty_row').each(function(i, obj){

          isHidden = $(this).find('.dmb_hide_of_member').is(':checked');
          if (!isHidden) {
            visibleMembers.push($(this));
          }

        });

        $.each(visibleMembers, function(i, obj){

          /* Gets row fields. */
          var fields = {};
      
          fields.firstname = $(this).find(".dmb_firstname_of_member").val();
          fields.lastname = $(this).find(".dmb_lastname_of_member").val();
          fields.job = $(this).find(".dmb_job_of_member").val();

          if ($('#acf-fallback-bio').length ) {
            fields.bio = $.trim($(this).find('.dmb_description_of_member_fb').text()) || '';
          } else {
            fields.bio = $.trim($(this).find('.dmb_description_of_member').html()) || '';
          }

          fields.scl_type1 = $(this).find(".dmb_scl_type1_of_member").find(":selected").val();
          fields.scl_title1 = $(this).find(".dmb_scl_title1_of_member").val();
          fields.scl_url1 = $(this).find(".dmb_scl_url1_of_member").val();
          fields.scl_type2 = $(this).find(".dmb_scl_type2_of_member").find(":selected").val();
          fields.scl_title2 = $(this).find(".dmb_scl_title2_of_member").val();
          fields.scl_url2 = $(this).find(".dmb_scl_url2_of_member").val();
          fields.scl_type3 = $(this).find(".dmb_scl_type3_of_member").find(":selected").val();
          fields.scl_title3 = $(this).find(".dmb_scl_title3_of_member").val();
          fields.scl_url3 = $(this).find(".dmb_scl_url3_of_member").val();
          fields.scl_type4 = $(this).find(".dmb_scl_type4_of_member").find(":selected").val();
          fields.scl_title4 = $(this).find(".dmb_scl_title4_of_member").val();
          fields.scl_url4 = $(this).find(".dmb_scl_url4_of_member").val();
          fields.scl_type5 = $(this).find(".dmb_scl_type5_of_member").find(":selected").val();
          fields.scl_title5 = $(this).find(".dmb_scl_title5_of_member").val();
          fields.scl_url5 = $(this).find(".dmb_scl_url5_of_member").val();
          fields.photoUrl = $(this).find(".dmb_img").attr('src');
          fields.photoLinkUrl = $(this).find(".dmb_photo_url_of_member").val();
          fields.hoverPhotoUrl = $(this).find('.dmb_hover_photo_of_member').attr('data-img');
          fields.comp_title = $(this).find('.dmb_comp_title_of_member').val();
          fields.comp_text = $(this).find('.dmb_comp_text_of_member').val();
          fields.color = dmb_rgb2hex($(this).find(".wp-color-result").css('backgroundColor')) || '#8dba09';

          /* Creates team container. */
          if(i%2 == 0) {
            /* If group of two (alignment). */
            preview_html += '<span class="tmm_two_containers_tablet"></span>';
          }
          if(i%settings.columns == 0) {
            /* If first member of group. */
            if(i > 0) {
              preview_html += '</div><span class="tmm_columns_containers_desktop"></span>';
            }
            preview_html += '<div class="tmm_container ' + team.equalizer + '">';
          }

          preview_html += '<div class="tmm_member" style="border-top:' + fields.color + ' solid ' + settings.tp_border_size + 'px;">';

            /* Displays photo. */
            if (fields.photoLinkUrl)
              preview_html += '<a ' + settings.piclink_beh + ' href="' + fields.photoLinkUrl + '" title="' + fields.firstname + ' ' + fields.lastname + '">';

              if (fields.photoUrl)
                preview_html += '<div class="tmm_photo ' + team.styling_classes + ' tmm_pic_' + i + '" style="background: url(' + fields.photoUrl + '); margin-left: auto; margin-right:auto; background-size:cover !important;"></div>';

              if (fields.hoverPhotoUrl)
                preview_html += '<style>.tmm_pic_' + i + ':hover {background: url(' + fields.hoverPhotoUrl + ') no-repeat !important;}</style>';

            if (fields.photoLinkUrl)
              preview_html += '</a>';

            /* Creates text block. */
            preview_html += '<div class="tmm_textblock">';

              /* Displays names. */
              preview_html += '<div class="tmm_names">';
              if (fields.firstname) {
                preview_html += '<span class="tmm_fname">' + fields.firstname + '</span> ';
              }
              if (fields.lastname) {
                preview_html += '<span class="tmm_lname">' + fields.lastname + '</span>';
              }
              preview_html += '</div>';

             /* Displays jobs. */
              if (fields.job) {
                preview_html += '<div class="tmm_job">' + fields.job + '</div>';
              }

              /* Displays bio. */
              if (fields.bio) {
                preview_html += '<div class="tmm_desc" style="text-align:' + settings.bio_alignment + '">' + fields.bio + '</div>';
              }

              /* Add. info box. */
              if (fields.comp_title) {
                preview_html += '<div style="margin-top:10px; margin-bottom:15px; color:' + fields.color + '" class="tmm_more_info">';
                  
                  /* Displays Add. info text */
                  if (fields.comp_text)
                    preview_html += '<div class="tmm_comp_text tmm_comp_text_' + settings.comp_theme + '">' + fields.comp_text + '</div>';

                  /* Display complementary info title */
                  preview_html += fields.comp_title;

                preview_html += '</div>';
              }

              /* Creates social block. */
              preview_html += '<div class="tmm_scblock">';
              
                /* Displays social links. */
                for (var j = 1; j <= 5; j++) {
                  
                  if (fields['scl_type' + j] != 'nada') {

                    var currentUrl = (fields['scl_url' + j]) ? fields['scl_url' + j] : '';
                    var currentTitle = (fields['scl_title' + i]) ? fields['scl_title' + j] : '';
                    if (fields['scl_type' + j] == 'email') {
                      preview_html += '<a class="tmm_sociallink" href="mailto:' + currentUrl + '" title="' + currentTitle + '"><img alt="' + currentTitle + '" src="../wp-content/plugins/' + pluginFolderSlug + '/inc/img/links/' + fields['scl_type' + j] + '.png"/></a>';
                    } else {
                      preview_html += '<a target="_blank" class="tmm_sociallink" href="' + currentUrl + '" title="' + currentTitle + '"><img alt="' + currentTitle + '" src="../wp-content/plugins/' + pluginFolderSlug + '/inc/img/links/' +fields['scl_type' + j] + '.png"/></a>';
                    }

                  }
                }

              preview_html += '</div>'; // Closes social block.
            preview_html += '</div>'; // Closes text block.
          preview_html += '</div>'; // Closes member.

          if (i == (team.memberCount - 1))
            preview_html += '<div style="clear:both;"></div>';

        });

        preview_html += '</div>'; // Closes container.
      preview_html += '</div>'; // Closes wrap.
    preview_html += '</div>'; // Closes tmm.
      
    preview_html += '<div style="clear:both;"></div>';

    preview_html += '<div class="dmb_accuracy_preview_notice">' + objectL10n.previewAccuracy + '</div>';

    /* Attaches content the preview to container. */
    (team.memberCount == 0)
    ? $('#dmb_preview_team').append('<div class="dmb_no_row_preview_notice">' + objectL10n.noMemberNotice + '</div>')
    : $('#dmb_preview_team').append(preview_html);
    
    /* Shows the preview box */
    $('#dmb_preview_team').fadeIn(100);

    tmm_equalize();
    
  });

  
  /* Closes the preview. */
  $('.dmb_preview_team_close').click(function(){
    $('#dmb_preview_team .tmm, .dmb_accuracy_preview_notice, .dmb_no_row_preview_notice').remove();
    $('#dmb_preview_team').fadeOut(100);
  });


  /* Unique editor. */
  if (!$('#acf-fallback-bio').length) {
    var lastEditedBio = '';
    /* Opens the UE to edit bios. */
    $('.dmb_edit_description_of_member').click(function(){

      lastEditedBio = $(this).parent().find('.dmb_description_of_member');
      var currentContent = lastEditedBio.html();
      if ($("#wp-dmb_editor-wrap").hasClass("tmce-active")){
        tinymce.activeEditor.setContent(currentContent);
      } else {
        $('#dmb_editor').val($.trim(currentContent));
      }
      $('#dmb_unique_editor').fadeIn(100);
      if (tinyMCE.activeEditor !== null) { tinyMCE.activeEditor.focus(); } 
      
    });
  }


  /* Saves the UE data. */
  if (!$('#acf-fallback-bio').length ) {
    $('.dmb_ue_update').click(function(){

      if ($("#wp-dmb_editor-wrap").hasClass("tmce-active")){
        var dmb_ue_content = tinyMCE.activeEditor.getContent();
      } else {
        var dmb_ue_content = $('#dmb_editor').val();
      }
      
      /* Hides bio block if empty. */
      (!dmb_ue_content) ? lastEditedBio.hide() : lastEditedBio.show();

      /* Adds bio content if there is. */
      lastEditedBio.html($.parseHTML(dmb_ue_content));

      /* Closes and empties UE. */
      $('#dmb_unique_editor').fadeOut(100);
      if (tinymce.activeEditor !== null) { tinymce.activeEditor.setContent(''); }

      dmbGatherData(lastEditedBio);
      return false;

    });
  }


  /* Cancels the UE updates. */
  if (!$('#acf-fallback-bio').length ) {
    $('.dmb_ue_cancel').click(function(){
      $('#dmb_unique_editor').fadeOut(100);
    });
  }


  /* Fallback editor (keyup) */
  $('body').on('paste keyup', '#acf-fallback-bio', debounce(function(){

    $(this).siblings('.dmb_description_of_member_fb').text($(this).val());
    dmbGatherData($(this));

  }, 600));


});
})(jQuery);