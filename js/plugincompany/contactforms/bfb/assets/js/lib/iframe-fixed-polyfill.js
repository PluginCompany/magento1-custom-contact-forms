(function(window){
    // *** Prepare configuration ***
    window.fixedConfig = window.fixedConfig || {};
    // *** Merge configuration ***
    window.fixedConfig.debug = window.fixedConfig.debug || false;
    window.fixedConfig.parent = window.fixedConfig.parent || window.parent;
    window.fixedConfig.parentScrollTopProperty = window.fixedConfig.parentScrollTopProperty || 'pageYOffset';
    window.fixedConfig.updateScrollTimeout = 10;
    // *** Static helpers ***
    // log: log something in the console, if the debug flag is set
    if ( !('log' in window.fixedConfig) )
        window.fixedConfig.log = function () {
            if ( window.fixedConfig.debug )
                console.log( '>> fixedConfig:', arguments );
        };
    // setInitialState: set the initial state of the element
    if ( !('setInitialState' in window.fixedConfig) )
        window.fixedConfig.setInitialState = function ( initialStyles ) {
            var me = this;

            me.updateTimeout = null;
            me.initialTop = initialStyles.top.indexOf('%') > -1 ? ( window.fixedConfig.parent.innerHeight / 100 * initialStyles.top.slice(0,-1) ) : me.element.offsetTop;
            me.element.style.top = me.initialTop + 'px';
        };
    // updateState: updates the element state on scroll
    if ( !('updateState' in window.fixedConfig) )
        window.fixedConfig.updateState = function () {
            var me = this,
                scrollTop = window.fixedConfig.parent[ window.fixedConfig.parentScrollTopProperty ];

            if ( me.updateTimeout ) clearTimeout( me.updateTimeout );
            me.updateTimeout = setTimeout( function() {
                window.fixedConfig.log( 'updateScroll', me, scrollTop );
                window.requestAnimationFrame( function (){
                    var newTop = me.initialTop + ( scrollTop >= window.frameElement.offsetTop - 50 ? scrollTop - window.frameElement.offsetTop + 50 : 0);
                    if((me.element.getBoundingClientRect().height + newTop) > window.frameElement.clientHeight) {
                        newTop = window.frameElement.clientHeight - me.element.getBoundingClientRect().height;
                    }
                    me.element.style.top = newTop + 'px';
                });
            }, window.fixedConfig.updateScrollTimeout );
        };
    // Initialize this polyfill when the document has been fully loaded, including CSS
    window.addEventListener('load', initPolyfill, false);

    // Observe for new added elements
    var observer = new MutationObserver(initPolyfill);
    observer.observe(document.documentElement, {
        childList: true,
        subtree: true
    });
    // -------------------------------------------------------------------
    function loop ( elements, callback ) {
        if ( elements ) {
            for ( var i = 0; i < elements.length; i++ ) {
                if ( callback ) callback( elements[i] );
            }
        }
    }
    // -------------------------------------------------------------------
    function initPolyfill () {
        if ( document.styleSheets ) {
            loop( document.styleSheets, function ( styleSheet ){
                loop( styleSheet.cssRules, function ( rule ){
                    if ( rule.style ) {
                        if ( rule.style.position == 'fixed' ) {
                            loop( document.querySelectorAll( rule.selectorText ), function ( element ){
                                new iFramePositionFixPolyfill( element, rule.style );
                            })
                        }
                    }
                })
            });
        }
    }
    // -------------------------------------------------------------------
    function iFramePositionFixPolyfill ( element, initialStyles ) {
        var me = this,
            isInitialized = ( element.getAttribute('data-iframe-position-fixed-initialized') === "true" );

        if ( !isInitialized ) {
            // Define properties
            me.element = element;

            // Allow the user to configure the initial position through the external helper method
            window.fixedConfig.setInitialState.call(me, initialStyles);

            // Initialize element position
            me.element.setAttribute( 'data-iframe-position-fixed-initialized', true );

            // When the parent scrolls, attempt to update the element position ever 500ms.
            // If another scroll event comes in place, cancel the previous attempt and retry.
            window.fixedConfig.parent.addEventListener( 'scroll', function ( event ){
                window.fixedConfig.updateState.call( me );
            }, {passive: true});
        }
    }
})(window);