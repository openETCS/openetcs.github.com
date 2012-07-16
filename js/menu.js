$(document).ready( function() {

  var enableNavigation = function() {
    
    var topLevelElements = $( "#menu li" );
      
    topLevelElements.mouseenter( function() {
      var secondLevelNav = $( this ).children( "ul" );
      secondLevelNav.stop();
      secondLevelNav.css( "opacity", "1" );
      secondLevelNav.fadeIn( 100 );
    } );
    
    topLevelElements.mouseleave( function() {
      var secondLevelNav = $( this ).children( "ul" );
      secondLevelNav.fadeOut( 250 );
    } );
    
    var secondLevelNav = $( "ul.second-level-nav" );
    secondLevelNav.mouseenter( function() {
      $( this ).stop();
      $( this ).css( "opacity", "1" );
    } );
  }

  var enableDownloadDropdowns = function() {
  
    $( '.expand-body' ).hide();

    $( '.download-button' ).hover( function() {
      $( this ).addClass( 'hover' );
    }, function() {
      $( this ).removeClass( 'hover' );
    } );

    $( '.expand-link' ).click( function() {
      var link = $( this );
      var body = link.closest( '.expand-head' ).next( '.expand-body' );
      var relatedItem = body.children( '.expand-item' ).eq( link.index() );
      if( body.is( ':visible' ) && relatedItem.is( ':visible' ) ) {
        body.slideUp( function() {
          link.removeClass( 'selected' );
        } );
      } else {
        relatedItem.show().siblings().hide();
        link.addClass( 'selected' ).siblings().removeClass( 'selected' );
        body.slideDown();
      }
    } );
  }

  enableNavigation();
  enableDownloadDropdowns();

} );
