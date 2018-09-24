@foreach($children as $child)
@if($view=='view')
  {{-- @if(isset($data)) --}}
    @if(in_array($child->title,$data))
        <ul>
            <input type="checkbox" name="groups[]" value="{{$child->id}}" class="uk-checkbox" checked>
            {{ ucfirst($child->title) }}
              @if(count($child->getChildren))
               @include('user.groups.groupChild',['children' => $child->getChildren,])
              @endif
        </ul>
      @endif
  
      @if(in_array($child->title,$arrayDiff))
        <ul>
          <input type="checkbox" name="groups[]" value="{{$child->id}}" class="uk-checkbox" >
          {{ ucfirst($child->title) }}
            @if(count($child->getChildren))
             @include('user.groups.groupChild',['children' => $child->getChildren,])
            @endif
        </ul>
      @endif
  {{-- @else
    <ul>
      <input type="checkbox" name="groups[]" value="{{$child->id}}" class="uk-checkbox" @if(is_array(old('groups')) && in_array($group->id, old('groups'))) checked @endif>
      {{ ucfirst($child->title) }}
      @if(count($child->getChildren))
        @include('user.groups.groupChild',['children' => $child->getChildren])
      @endif
    </ul> --}}
  {{-- @endif --}}
@else  
  <tr> 
    <td><input type="checkbox" name="groups[]" value="{{$child->id}}" class="uk-checkbox"></td>
    <td>{{ ucfirst($child->title) }}</td>
     <td> <a href="{{ route('user-groups.edit',['group'=>$child]) }}" ><span class="uk-text-success">Modifier</span></a>
            </td>
            <td> <form action="{{ route('user-groups.destroy',['group'=>$child]) }}" method="POST" id="deleteForm" onsubmit="return confirm('Êtes vous sûre de bien vouloir supprimer ce groupe?')">
                @csrf
                @method('delete')
<button class="uk-button uk-button-link"><span class="uk-text-danger">Supprimer</span></button>
            </form> 
            </td>
    <td> {{$child->id }}</td> 
  </tr>
  @if(count($child->getChildren))
    @include('user.groups.groupChild',['children' => $child->getChildren])
  @endif
@endif
@endforeach


