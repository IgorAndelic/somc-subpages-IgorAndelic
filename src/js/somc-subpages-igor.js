(function($) {
    function SomcSubpages() {
        documentReady = function() {
            // bind the expand and button sort on click events
            $('.subpages-button-expand').click(expandList);
            $('.subpages-button-sort').click(selectElements);
        }

        expandList = function(event) {
            // get the current target
            $current = $(event.currentTarget);
            // find the closest item with children
            $container = $current.closest('.page_item_has_children');
            // toggle the expand class
            $container.toggleClass('expanded');
        }

        selectElements = function(event) {
            // get the current target
            $current = $(event.currentTarget);
            // find ul element
            $container = $current.next('ul');
            // get all the li elements under the ul element and return as `Array`
            $elements = $container.find('> li').get();
            // check if the current node is sorted ascending
            isAscending = $current.hasClass('subpages-sortorder-asc');
            // toggle the sort order class
            $current.toggleClass('subpages-sortorder-asc');

            // sort
            $elements.sort(function(a, b) {
                // sorts differently depending on ascending or descending
                if(isAscending) {
                    if(a.innerText < b.innerText) return -1;
                    if(a.innerText > b.innerText) return 1;
                } else {
                    if(a.innerText < b.innerText) return 1;
                    if(a.innerText > b.innerText) return -1;
                }

                return 0;
            });

            // show the elements after being sorted
            $.each($elements, function(i, li) {
                $container.append(li);
            });
        }

        // call function on document ready
        $(document).ready(documentReady);
    }

    new SomcSubpages();
})(jQuery);