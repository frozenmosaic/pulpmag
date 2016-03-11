// function change() {
//     var type = document.getElementById('select').value;
//     var parentDiv = document.getElementById('new');
//     if (type == 'Search Full-text') {
//         parentDiv.innerHTML = "<p>default</p>";
//     }
// }
// function add() {
//     var row = document.getElementById('add-phrase');
//     var newRow = row.cloneNode(true);
//     row.insertAfter(newRow);
// }
var adminObject = {
    /* MAJORS IN ADD PAGE */
    add: function(thisIdentity) {
        "use strict";
        $(document).on('click', thisIdentity, function(e) {
            e.preventDefault();
            var lastRow = $('#search-phrase');
            var lastRowId = lastRow.data('id');
            var toClone = $('#phraseTemplate');
            if (lastRowId == 1) {
                toClone.css("display", "block");
            } else {
                var newRow = toClone.clone();
                newRow.val("");
                newRow.css('display', 'block');
                newRow.insertAfter(lastRow);
            }
            lastRow.data('id', lastRowId + 1);
        });
    },
    remove: function(thisIdentity) {
        "use strict";
        $(document).on('click', thisIdentity, function(e) {
            e.preventDefault();
            var lastRow = $('#search-phrase');
            var lastRowId = lastRow.data('id');
            if (lastRowId == 2) {
                var toRemove = $('#phraseTemplate');
                toRemove.css("display", "none");
            } else {
                var toRemove = $(this).parents('.formGroup');
                toRemove.remove();
            }
        });
    }
}
$(function() {
    "use strict";
    adminObject.add('#add-phrase');
    adminObject.remove('#remove-phrase');
})