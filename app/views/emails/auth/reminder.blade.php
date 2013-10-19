<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ trans('auth.emails.forgottemplate.title') }}</h2>

		<div>
            {{ trans('auth.emails.forgottemplate.message') }} {{ URL::to('password/reset', array($token)) }}.
		</div>
	</body>
</html>