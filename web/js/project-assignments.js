(function($){
  var updateView = function (tbl_size){
    if($('#person').children('option').length == 0){
      $("#add-person-div").hide();
    }else{
      $("#add-person-div").show();
    }

    if(tbl_size > 0){
      $("#assignments").show();
      $("#no-person-div").hide();
    }else{
      $("#assignments").hide();
      $("#no-person-div").show();
    }
  }

  var assignPerson = function(){
    $.ajax({
      url: "{{ path('assign_person') }}",
      type: "POST",
      data: {
        project_id: $("#project").val(),
        person_id: $("#person").val()
      },
      dataType: "JSON",
      error: function (request, status, error) {
        console.log(error);
      },
      success: function (response) {
        var tbl_size = $('#assignments tr').size()-1;
        var newRow = '<tr data-row-id='+$("#person").val()+'><td>'+$("#person option:selected").text()+'</td><td><a class="remove-button" data-row-id="'+$("#person").val()+'" href="#">{{ 'Remove'|trans }}</a></td></tr>';

        $(newRow).click(function(){
          unassignPerson($(this));
        });

        $('#assignments').append(newRow)
        tbl_size++;

        $("#unassigned-option-"+$("#person").val()).remove();

        updateView(tbl_size);
      }
    })
  }

  var unassignPerson = function(a){
    $.ajax({
      url: "{{ path('unassign_person') }}",
      type: "POST",
      data: {
        project_id: $("#project").val(),
        person_id: $(a).attr('data-row-id')
      },
      dataType: "JSON",
      error: function (request, status, error) {
        console.log(error);
      },
      success: function (response) {
        var $tr = $(a).closest('tr');
        var tbl_size =$('#assignments tr').size()-1;

        $tr.find('td').fadeOut(300,function(){
          $tr.remove();
        });
        tbl_size--;

        $("#person").append('<option id="unassigned-option-'+$(a).attr('data-row-id')+'" value="'+$(a).attr('data-row-id')+'">'+$(a).closest('tr').children('td.assignment-info').text()+'<\/option>');

        updateView(tbl_size);
      }
    })
  }

  $(document).ready(function(){
    $("#submit").click(function(){
      assignPerson();
    });
    $(".remove-button").click(function(){
      unassignPerson($(this));
    });
  });
})(jQuery);
