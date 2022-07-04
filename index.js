
function getData()
{
  $.ajax({
    url: "api/?get",
    context: document.body
  }).done(function(data) {

    // get request
    $.getJSON('api/?get', function(data)
    {
      $('table').remove();
      let sizeOfData = data.length;
      // create table with data
      var table = $('<table>').addClass('table');
      table.append('<tr>');
      table.append('<th>id</th>');
      table.append('<th>firstname</th>');
      table.append('<th>lastname</th>');
      table.append('<th>state</th>');
      table.append('<th>age</th>');
      table.append('<th>pw</th>');
      table.append('</tr>');
      $.each(data, function(key, val)
      {
          table.append('<tr>');
          table.append('<td>'+val.id+'</td>');
          table.append('<td>'+val.firstname+'</td>');
          table.append('<td>'+val.lastname+'</td>');
          table.append('<td>'+val.state+'</td>');
          table.append('<td>'+val.age+'</td>');
          table.append('<td>'+val.pw+'</td>');
          table.append('</tr>');
      });
      table.append('</table>');
      $('body').append('<p></p>');
      $('body').append(table);
      let text;
      if(sizeOfData == undefined)
      {
        text='';
      }else{
        text=' ('+sizeOfData+')';
      }
      $("#input").html('Got data'+text).addClass('btn btn-success');
    });

  });
}
function createData()
{
  $.ajax({
    url: "api/?get&opt=insert",
    context: document.body
  }).done();
}
