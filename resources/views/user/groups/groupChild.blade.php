  					
@foreach($children as $child)
@if($view=='accessLevelView')

 <ul>
 	<input type="checkbox" name="groups[]" value="{{$child->id}}" class="uk-checkbox" @if(is_array(old('groups')) && in_array($group->id, old('groups'))) checked @endif>
 	{{ ucfirst($child->title) }}
 

    @if(count($child->getChildren))
    <ul> 

    @include('user.groups.groupChild',['children' => $child->getChildren,])
   </ul>        
        @endif
</ul>
  @else  
  <tr> 
 <td> 
 
 	<input type="checkbox" name="groups[]" value="{{$child->id}}" class="uk-checkbox"></td>
        <td>{{ ucfirst($child->title) }}</td>
                <td> {{$child->id }}

                </td> 
                 </tr>

 

    @if(count($child->getChildren))
            @include('user.groups.groupChild',['children' => $child->getChildren])
           
        @endif
        @endif
@endforeach


