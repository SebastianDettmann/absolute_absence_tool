<p>{{ __('Hallo :user,', ['user' => $user->fullName()]) }}</p>
<p></p>
<p>{{ __('Sie erhalten diese E-Mail, um Ihr Passwort zu setzen. Grund dafür ist Ihre Neuanmeldung im System oder Ihr Wunsch Ihr Passwort zu ändern.') }}</p>
<p></p>
<p>{{ __('Klicken Sie auf den nachstehenden Link, um Ihr Passwort zu setzen:') }}</p>
<p></p>
<p>
    <a href="{{ $link = url(config('app.url').route('password.reset', $token, false)) }}">{{ $link }}</a>
</p>
<p></p>
<p>{{ __('Der Link bleibt für 24 Stunden gültig.') }}</p>
<p></p>
<p>{{ __('Bitte antworten Sie nicht auf diese automatisch generierte E-Mail.') }}</p>
<p></p>
<p>{{ __('Diese E-Mail wurde von :sender an die E-Mail-Adresse :email versendet.', [
    'sender' => url(config('app.url')),
    'email' => $user->email,
]) }}</p>