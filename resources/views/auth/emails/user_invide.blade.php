<p>{{ __('Hallo :user,', ['user' => $user->fullName()]) }}</p>
<p></p>
<p>{{ __('wir haben für Sie einen Account angelegt.') }}</p>
<p></p>
<p>{{ __('Klicken Sie auf den nachstehenden Link, um Ihr Passwort zu setzen:') }}</p>
<p></p>
<p>
    <a href="{{ $link = url(config('app.url').'/auth/password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">{{ $link }}</a>
</p>
<p></p>
<p>{{ __('Der Link bleibt für 24 Stunden gültig.') }}</p>
<p></p>
<p>{{ __('Falls Sie durch Klicken auf den Link nicht weitergeleitet werden, können Sie den Link kopieren und in das Adressfenster Ihres Browsers einfügen oder den Link selbst dort eingeben.') }}</p>
<p></p>
<p>{{ __('Bitte antworten Sie nicht auf diese automatisch generierte E-Mail.') }}</p>
<p></p>
<p>{{ __('Diese E-Mail wurde von :sender an die E-Mail-Adresse :email versendet.', [
    'sender' => url(config('app.url')),
    'email' => $user->email,
]) }}</p>