<h3>{{ ('Reinitialisation du mot de password') }} </h3>
<form method="POST" action="{{ route('users.update',['user'=>$user]) }}" enctype="multipart/form-data" class="">
                        @csrf
@method ('put')
                        <div>
                            <label for="name">{{ ('Nom') }}</label>
                            <input id="name" type="text" name="name" value="{{$user->name }}" required autofocus>            
                        </div>

                        <div>
                            <label for="email">{{ ('Adresse E-mail') }}</label>
                            <input id="email" type="email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div>
                            <label for="title">{{ ('Fonction') }}</label>
                            <input id="title" type="text" name="title" value="{{ old('title') }}" >
                        </div>
                         <div>
                            <label for="facebook-address">{{ ('Adresse facebook') }}</label>
                            <input id="facebook-address" type="text" name="facebook-address" value="{{ old('facebook-address') }}" >
                        </div>
                        <div>
                            <label for="google-address">{{ ('Adresse google') }}</label>
                            <input id="google-address" type="text" name="google-address" value="{{ old('google-address') }}" >
                            <div>
                            <label for="twitter-address">{{ ('Adresse twitter') }}</label>
                            <input id="twitter-address" type="text" name="twitter-address" value="{{ old('twitter-address') }}" >
                        </div>
                        </div>

                        <div>
                            <label for="password">{{('Mot de passe') }}</label>
                            <input id="password" type="password" name="password" required>
                        </div>

                        <div>
                            <label for="password-confirm">{{('Confirmer le mot de passe') }}</label>
                            <input id="password-confirm" type="password"  name="password_confirmation" required>
                        </div>
                        <div>
                            <label for="is_active">{{('Actif') }}</label>
                            <select name="is_active">
                                <option value="{{ 1 }}">{{ ('Actif') }}</option>
                                <option value="{{ 0 }}">{{ ('Inactif') }}</option>
                            </select>
                        </div>
<div>
                            <label for=image">{{('Photo') }}</label>
                            <input id=image" type="file"  name="image">
                        </div>

                           <div>
                            <label for="require_reset">{{('Changer le mot de passe a la prochaine connexion') }}</label>
                            <select name="require_reset">
                                <option value="{{ 0 }}">{{ ('Oui') }}</option>
                                <option value="{{ 1 }}">{{ ('Non') }}</option>
                            </select>
                        </div>
                        <div>
                                <button type="submit" class="btn btn-primary">
                                    {{('Enregistrer') }}
                                </button>
                          
                        </div>
                    </form>
         