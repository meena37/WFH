<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>jQuery UI Draggable - Default functionality-nicesnippets.com</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <style>
    #draggable { 
        width: 150px;
        height: 150px;
        padding: 0.5em;
    }
  </style>
</head>
<body class="bg-light">
<div class="container">
  <div class="row">
    <div class="col-md-12">
         <div class="row">
            <div class="col-md-5 p-3 bg-dark offset-md-1">
                <table><tbody class="list-group shadow-lg connectedSortable" id="padding-item-drop">
                  @if(!empty($panddingItem) && $panddingItem->count())
                    @foreach($panddingItem as $key=>$value)
                      <tr class="list-group-item" item-id="{{ $value->id }}"><td>{{ $value->title }}</td><td>{{ $value->title }}</td><td>{{ $value->title }}</td></tr>
                 
                    @endforeach
                  @endif
                </tbody></table>
            </div>
             
        </div>
    </div>
  </div>
</div>
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script>
  $( function() {
    $( "#padding-item-drop, #complete-item-drop" ).sortable({
      connectWith: ".connectedSortable",
      opacity: 0.5,
    }).disableSelection();

    $( ".connectedSortable" ).on( "sortupdate", function( event, ui ) {
        var panddingArr = [];
        var completeArr = [];

        $("#padding-item-drop tr").each(function( index ) {
          panddingArr[index] = $(this).attr('item-id');
        });

        $("#complete-item-drop tr").each(function( index ) {
          completeArr[index] = $(this).attr('item-id');
        });

        $.ajax({
            url: "{{ route('update.items') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {panddingArr:panddingArr,completeArr:completeArr},
            success: function(data) {
              console.log('success');
            }
        });
          
    });
  });
</script>
</body>
</html>