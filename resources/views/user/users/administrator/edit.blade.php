@extends('layouts.administrator.master')
@section('title', 'Edit a user')
@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@section('content')


<form method="POST" action="{{ route('users.update',['user'=>$user]) }}" enctype="multipart/form-data" class="">
    @csrf
    @method ('put')
    
    @section('sidebar')
    @component('layouts.administrator.user-sidebar') @endcomponent 
    @endsection

    <div id="tabs">
      <ul>
        <li><a href="#fragment-1"><span>utilisateur</span></a></li>
        <li><a href="#fragment-2"><span>Groupes</span></a></li>
        
    </ul>
    <div id="fragment-1">
     <div>
        <button type="submit" name="update" value="update">{{ ('Modifier') }}</button>
        <button type="submit" name="cancel" value="cancel"> {{ ('Annuler') }}</button>
    </div>  <div>
        <label for="name">{{ ('Nom') }}</label>
        <input id="name" type="text" name="name" value="{{$user->name }}" required autofocus>            
    </div>

    <div>
        <label for="email">{{ ('Adresse E-mail') }}</label>
        <input id="email" type="email" name="email" value="{{ $user->email }}" required>
    </div>
    <div>
        <label for="title">{{ ('Fonction') }}</label>
        <input id="title" type="text" name="title" value="{{ (json_decode($user->data))->title}}" >
    </div>
    <div>
     
        <label for="facebook">{{ ('Adresse facebook') }}</label>
        <input id="facebook" type="text" name="facebook" value="{{ (json_decode($user->data))->facebook}}" >
    </div>
    <div>
        <label for="google">{{ ('Adresse google') }}</label>
        <input id="google" type="text" name="google" value="{{ (json_decode($user->data))->google}}" >
        <div>
            <label for="twitter">{{ ('Adresse twitter') }}</label>
            <input id="twitter" type="text" name="twitter" value="{{ (json_decode($user->data))->twitter}}" >
        </div>
    </div>

    <div>
        <label for="password">{{('Mot de passe') }}</label>
        <input id="password" type="password" name="password" value="" >
    </div>

    <div>
        <label for="password-confirm">{{('Confirmer le mot de passe') }}</label>
        <input id="password-confirm" type="password"  name="password_confirmation" value="" >
    </div>
    <div>
        <label for="is_active">{{('Actif') }}</label>
        <select name="is_active">
            <option value="{{ 1 }}" @if($user->is_active==1) selected @endif>{{ ('Actif') }}</option>
            <option value="{{ 0 }}" @if($user->is_active==0) selected @endif>{{ ('Inactif') }}</option>
        </select>
    </div>
    <div>
        <label for=image">{{('Photo') }}</label>
        <input id=image" type="file"  name="image">
    </div>

    <div>
       
        <label for="require_reset">{{('Changer le mot de passe a la prochaine connexion') }}</label>
        <select name="require_reset">
            <option value="{{ 0 }}" @if($user->require_reset==0) selected @endif>{{ ('Oui') }}</option>
            <option value="{{ 1 }}" @if($user->require_reset==1) selected @endif>{{ ('Non') }}</option>
        </select>
    </div>
</div>
<div id="fragment-2">
   <div>
     
    @foreach($allGroups as $group)
    @if(in_array($group->title,$userGroups))
    <ul>
        <input type="checkbox" name="groups[]" value="{{$group->id}}" class="uk-checkbox"  checked>
        {{ ucfirst($group->title) }}
        @if(count($group->getChildren))
        @include('user.groups.administrator.groupChild',['children' => $group->getChildren,'view'=>'view','data'=>$userGroups,'arrayDiff'=>$arrayDiff])
        @endif
    </ul>     
    @elseif(in_array($group->title,$arrayDiff))
    <ul>
        <input type="checkbox" name="groups[]" value="{{$group->id}}" class="uk-checkbox">
        {{ ucfirst($group->title) }}
        @if(count($group->getChildren))
        @include('user.groups.administrator.groupChild',['children' => $group->getChildren,'view'=>'view','data'=>$userGroups,'arrayDiff'=>$arrayDiff])
        @endif
    </ul>  
    @endif 

    @endforeach 
</div>   
</div>

</div>
</form>
<script>
    $( "#tabs" ).tabs();
</script>
@endsection
