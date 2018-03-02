$(document).ready(() => {
  // Makes the inside body of the tables sortable
  $('.table-body').sortable({
    connectWith: '.connectedSortable',
    receive(e, ui) {
      // ui.sender.data('copied', true);
      let user_id = ui.item[0].id;
      let tavolo_id = this.dataset.rel;
      // $('#'+user_id).css('display', 'none');
      $.ajax({
        url: "./includes/update-guest-table.inc.php",
        method: "POST",
        data: { user_id: user_id, tavolo_id: tavolo_id },
        dataType: "json"
      });
    },
  });

  $('#guest-list').sortable({
    connectWith: '.connectedSortable',
    receive(e, ui) {
      // ui.sender.data('copied', true);
      let user_id = ui.item[0].id;
      let tavolo_id = this.dataset.rel;
      // $('#'+user_id).css('display', 'none');
      $.ajax({
        url: "./includes/update-guest-table.inc.php",
        method: "POST",
        data: { user_id: user_id, tavolo_id: tavolo_id },
        dataType: "json"
      });
    },
  });

  // Show Add Guest Modal
  $('#add-guest').click(() => {
    document.getElementById('add-guest-modal').style.display = 'block';
  });
  // Show Add Table Modal
  $('#add-table').click(() => {
    document.getElementById('add-table-modal').style.display = 'block';
  });

  // When close button of the guest modal is clicked it hides the modal
  $('#close1').click(() => {
    document.getElementById('add-guest-modal').style.display = 'none';
  });

  // When close button of the table modal is clicked it hides the modal
  $('#close2').click(() => {
    document.getElementById('add-table-modal').style.display = 'none';
  });

  $('#guest-list').sortable({
    connectWith: '.connectedSortable',
    cursor: 'move',
    helper: 'clone'
  });

  $('.table-body').sortable({
    connectWith: '.connectedSortable',
    cursor: 'move',
    helper: 'clone'
  });

  // Filter guest list to show guests in need of assignment to a table
  if ($('#to-assign').is(':checked')) {
    $.getJSON("./includes/get-guest-to-assign.inc.php", function (response) {
      $('#guest-list').html("");
      response.forEach(function (data) {
        $('#guest-list').append(`
        <div class="guest" id="${data.id}">
          <p class="family-name">${data.nome} ${data.cognome}</p>
          <p class="number-adults">${data.adulti}</p>
          <p class="number-babies">${data.bambini}</p>
          <p class="number-highchair">${data.seggioloni}</p>
          <p class="number-intolerant">${data.note_intolleranze}</p>
        </div>`);
      });
    });
    // Filter guest list to show guests that were already assigned to a table
  } else if ($('#assigned').is(':checked')) {
    $.getJSON("./includes/get-guest-assigned.inc.php", function (response) {
      $('#guest-list').html("");

      response.forEach(function (data) {
        $('#guest-list').append(`
        <div class="guest" id="${data.id}">
          <p class="family-name">${data.nome} ${data.cognome}</p>
          <p class="number-adults">${data.adulti}</p>
          <p class="number-babies">${data.bambini}</p>
          <p class="number-highchair">${data.seggioloni}</p>
          <p class="number-intolerant">${data.note_intolleranze}</p>
        </div>`);
      });
    });
  }

  // Add an event handler to the assignment buttons
  $('.assign-btns').change(function () {
    // Checked if the "To Assign" button is checked
    if ($('#to-assign').is(':checked')) {
      // If its checked make the guest list sortable
      $('#guest-list').sortable({
        connectWith: '.connectedSortable',
        cursor: 'move',
        helper(e, div) {
          this.copyHelper = div.clone().insertAfter(div);
          $(this).data('copied', false);
          return div.clone();
        },
        stop() {
          const copied = $(this).data('copied');
          if (!copied) {
            this.copyHelper.remove();
          }
          this.copyHelper = null;
        },
      });

      // Filter guest list to show guests in need of assignment after radio change
      $.getJSON("./includes/get-guest-to-assign.inc.php", function (response) {
        $('#guest-list').html("");
        $('#guest-list').addClass('connectedSortable');
        response.forEach(function (data) {
          $('#guest-list').append(`
          <div class="guest" id="${data.id}">
            <p class="family-name">${data.nome} ${data.cognome}</p>
            <p class="number-adults">${data.adulti}</p>
            <p class="number-babies">${data.bambini}</p>
            <p class="number-highchair">${data.seggioloni}</p>
            <p class="number-intolerant">${data.note_intolleranze}</p>
          </div>`);
        });
      });
      // Filter guest list to show guests assigned after radio change
    } else if ($('#assigned').is(':checked')) {
      $('#guest-list').sortable("destroy");
      $('#guest-list').removeClass('connectedSortable');
      $('#guest-list').removeClass('ui-sortable');
      $.getJSON("./includes/get-guest-assigned.inc.php", function (response) {
        $('#guest-list').html("");
        $('#guest-list').removeClass('connectedSortable');
        $('#guest-list').removeClass('ui-sortable');
        response.forEach(function (data) {
          $('#guest-list').append(`
          <div class="guest" id="${data.id}">
            <p class="family-name">${data.nome} ${data.cognome}</p>
            <p class="number-adults">${data.adulti}</p>
            <p class="number-babies">${data.bambini}</p>
            <p class="number-highchair">${data.seggioloni}</p>
            <p class="number-intolerant">${data.note_intolleranze}</p>
          </div>`);
        });
      });
    }
  });
});
