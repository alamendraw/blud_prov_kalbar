/* 
 * DO NOT REMOVE THIS LICENSE
 * 
 * This source code is created by Muhammad Fauzil Haqqi.
 * You can use and modify this source code freely but
 * you are forbidden to change or remove this license.
 * 
 * Nick          : Haqqi
 * YM            : fauzil.haqqi
 * Email & GTalk : me@haqqi.net
 * Site          : http://haqqi.net
 * Company       : http://mimicreative.net
 */

(function($){
  $.confirm = function(params){

    if($('#confirmMask').length){
      // jika sudah ada dialog konfirmasi yang tampil
      return false;
    }

    var buttonHTML = '';
    $.each(params.buttons,function(name,obj){
      // membuat struktur html untuk tombol
      buttonHTML += '<a href="#" class="button '+obj['class']+'">'+name+'<span></span></a>';
      // jika action tidak didefinisikan
      if(!obj.action){
        obj.action = function(){};
      }
    });

    // membuat struktur dialog markup
    var markup = [
    '<div id="confirmMask">',
    '<div id="confirmBox">',
    '<h1>',params.title,'</h1>',
    '<p>',params.message,'</p>',
    '<div id="confirmButtons">',
    buttonHTML,
    '</div></div></div>'
    ].join('');

    // menyematkan dialog pada body
    $(markup).hide().appendTo('body').fadeIn();

    // meletakkan di tengah
    var top = ($(window).height() - $("#confirmBox").height())/2;
    var left = ($(window).width() - $("#confirmBox").width())/2;
    $("#confirmBox").css("top", top + "px").css("left", left + "px");
    // untuk perubahan ukuran jendela
    $(window).resize(function() {
      var top = ($(window).height() - $("#confirmBox").height())/2;
      var left = ($(window).width() - $("#confirmBox").width())/2;
      $("#confirmBox").css("top", top + "px").css("left", left + "px");
    });

    // memberikan event ke button
    var buttons = $('#confirmBox .button'),
    i = 0;

    $.each(params.buttons,function(name,obj){
      buttons.eq(i++).click(function(){
        // memanggil action dari object
        obj.action();
        $.confirm.hide();
        return false;
      });
    });
  }

  // fungsi untuk menghilangkan dialog
  $.confirm.hide = function(){
    $('#confirmMask').fadeOut(function(){
      $(this).remove();
    });
  }
})(jQuery);