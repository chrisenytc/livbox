<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| such as the size rules. Feel free to tweak each of these messages.
	|
	*/

	"accepted"         => "O campo :attribute deve ser aceito.",
	"active_url"       => "O campo :attribute não é uma URL válida.",
	"after"            => "O campo :attribute deve ser uma data após :date.",
	"alpha"            => "O campo :attribute só pode conter letras.",
	"alpha_dash"       => "O campo :attribute só pode conter letras, números e hífens.",
	"alpha_num"        => "O campo :attribute só pode conter letras e números.",
	"array"            => "O campo :attribute deve ser um array.",
	"before"           => "O campo :attribute deve ser uma data antes :date.",
	"between"          => array(
		"numeric" => "O campo :attribute deve estar entre :min - :max.",
		"file"    => "O campo :attribute deve estar entre :min - :max kilobytes.",
		"string"  => "O campo :attribute deve estar entre :min - :max caracteres.",
		"array"   => "O campo :attribute deve ter entre :min - :max itens.",
	),
	"confirmed"        => "O campo :attribute confirmação não corresponde.",
	"date"             => "O campo :attribute não é uma data válida.",
	"date_format"      => "O campo :attribute não corresponde ao formato :format.",
	"different"        => "O campo :attribute e :other devem ser diferentes.",
	"digits"           => "O campo :attribute deve ser :digits digitos.",
	"digits_between"   => "O campo :attribute deve estar entre :min e :max digitos.",
	"email"            => "O campo :attribute está com um formato inválido.",
	"exists"           => "O campo selected :attribute é inválido.",
	"image"            => "O campo :attribute deve ser uma imagem.",
	"in"               => "O campo selected :attribute é inválido.",
	"integer"          => "O campo :attribute deve ser um inteiro.",
	"ip"               => "O campo :attribute deve ser um endereço IP válido.",
	"max"              => array(
		"numeric" => "O campo :attribute não pode ser maior do que :max.",
		"file"    => "O campo :attribute não pode ser maior do que :max kilobytes.",
		"string"  => "O campo :attribute não pode ser maior do que :max caracteres.",
		"array"   => "O campo :attribute não deve haver mais do que :max itens.",
	),
	"mimes"            => "O campo :attribute deve ser a file of type: :values.",
	"min"              => array(
		"numeric" => "O campo :attribute deve haver pelo menos :min.",
		"file"    => "O campo :attribute deve haver pelo menos :min kilobytes.",
		"string"  => "O campo :attribute deve haver pelo menos :min caracteres.",
		"array"   => "O campo :attribute deve ter pelo menos :min itens.",
	),
	"not_in"           => "O campo :attribute selecionado é inválido.",
	"numeric"          => "O campo :attribute deve ser um número.",
	"regex"            => "O campo :attribute está em um formato inválido.",
	"required"         => "O campo :attribute é obrigatório.",
	"required_if"      => "O campo :attribute é obrigatório quando :other é :value.",
	"required_with"    => "O campo :attribute é obrigatório quando :values está presente.",
	"required_without" => "O campo :attribute é obrigatório quando :values não está presente.",
	"same"             => "O campo :attribute e :other devem ser iguais.",
	"size"             => array(
		"numeric" => "O campo :attribute deve ser :size.",
		"file"    => "O campo :attribute deve ser :size kilobytes.",
		"string"  => "O campo :attribute deve ser :size characters.",
		"array"   => "O campo :attribute deve ter :size itens.",
	),
	"unique"           => "O campo :attribute já existe.",
	"url"              => "O campo :attribute está em um formato inválido.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

);
