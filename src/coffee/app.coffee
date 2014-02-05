#
#Module: livbox
#Name: Christopher EnyTC
#Username: chrisenytc
#Site: http://chris.enytc.com
#Github: https://github.com/chrisenytc/livbox
#Twitter: @chrisenytc
#

#Module
app = angular.module('livboxApp', [])

#Addons
$(document).ready ->
  #Tooltip
  $('[data-toggle=tooltip]').tooltip()
	#Collapse
	$('.collapse').collapse()