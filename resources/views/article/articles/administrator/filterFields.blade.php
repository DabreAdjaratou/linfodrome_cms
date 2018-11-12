<div>
    
  <label> Affiché </label>
  <select id=entries name="entries" class="searchValue"> 
    @for($i=0; $i<sizeof($entries);$i++)
    <option value="{{ $entries[$i] }}" @if($entries[$i] == $articles->perPage())  selected @endif>{{ $entries[$i] }}</option>
    @endfor
  </select> <label> lignes</label>
  </div>


  <div>
    <input type="text" name="searchByTitle" id="searchByTitle" class="searchValue" @if(isset($searchByTitle)) value="{{$searchByTitle}}" @endif autocomplete="off" placeholder="--Titre--"><button  id="searchButton" name="searchButton">chercher</button>
    <select name="searchByCategory" id="searchByCategory" class="searchValue">
      <option value="">-- Categorie --</option>
      @foreach($categories as $category)
      <option value="{{$category->id}}" @if(isset($searchByCategory) && $category->id==$searchByCategory) selected @endif>{{$category->title}}</option>
      @endforeach
    </select>
    <select name="searchByFeaturedState" id="searchByFeaturedState" class="searchValue">
      <option value="null" >-- Vedette --</option>
      <option value="0" @if(isset($searchByFeaturedState) && $searchByFeaturedState==0) selected @endif>Pas à la une</option>
      <option value="1" @if(isset($searchByFeaturedState) && $searchByFeaturedState==1) selected @endif>A la une</option>
    </select>

    <select name="searchByPublishedState" id="searchByPublishedState" class="searchValue">
      <option value="null">-- Etat de publication --</option>
      <option value="0" @if(isset($searchByPublishedState) && $searchByPublishedState==0) selected @endif>Non publié</option>
      <option value="1" @if(isset($searchByPublishedState) && $searchByPublishedState==1) selected @endif>Publié</option>
    </select>

    <select name="searchByUser" id="searchByUser" class="searchValue">
      <option value="">-- User --</option>
      @foreach($users as $user)
      <option value="{{$user->id}}" @if(isset($searchByUser) && $user->id==$searchByUser) selected @endif>{{$user->name}}</option>
      @endforeach
    </select>
    <div class="uk-display-inline-block">De: <input type="text" class="datepicker" id="fromDate" @if(isset($fromDate)) value='{{ date("d/m/Y", strtotime($fromDate))}}' @endif autocomplete="off"></div>
    <div class="uk-display-inline-block">A: <input type="text" class="datepicker" id="toDate" @if(isset($toDate)) value='{{ date("d/m/Y", strtotime($toDate))}}' @endif autocomplete="off"></div>


  </div>
  <div>