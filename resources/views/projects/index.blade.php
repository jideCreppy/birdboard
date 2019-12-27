<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    @forelse ($projects as $project)
     <ul>
         <li>
             <a href="{{$project->path()}}">{{$project->title}}</a>
        </li>
     </ul>
     @empty
         No Project Found
    @endforelse

</body>
</html>