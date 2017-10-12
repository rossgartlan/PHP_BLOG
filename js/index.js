/* global imgPos */

$(document).ready(function() {
  $('i').hide();
});

$(window).load(function() {
  $('i').show();

  var twitterPos = $('#twitter').position();
  var codePos = $('#code').position();
  var plusPos = $('#plus').position();
  var mailPos = $('#mail').position();
  
  
  $('i').css({
    position: 'absolute',
    zIndex: '1',
    top: imgPos.top + 100,
    left: '47%'
  });
  
  setTimeout(function() {
    $('#twitter').animate({
      top: twitterPos.top + 10,
      left: twitterPos.left - 10
    }, 500);
  }, 250);
  
  setTimeout(function() {
    $('#twitter').animate({
      top: twitterPos.top,
      left: twitterPos.left
    }, 250);
    
    
    $('#code').animate({
      top: codePos.top + 10,
      left: codePos.left + 3
    }, 500);
  }, 1250);
  
  setTimeout(function() {
    $('#code').animate({
      top: codePos.top,
      left: codePos.left
    }, 250);
    
    $('#plus').animate({
      top: plusPos.top + 10,
      left: plusPos.left + 6
    }, 500);
  }, 1500);
  
  setTimeout(function() {
    $('#plus').animate({
      top: plusPos.top,
      left: plusPos.left
    }, 250);
    
    $('#mail').animate({
      top: mailPos.top + 10,
      left: mailPos.left + 10
    }, 500);
  }, 1750);
  
  setTimeout(function() {
    $('#mail').animate({
      top: mailPos.top,
      left: mailPos.left
    }, 250);
  }, 2000);
  
});