osch=0
echo "1. Unix (Sun OS)"
echo "2. Linux (Red Hat)"
echo -n "select your os choice [1 or 2]"
read osch
if [ $osch -eq 1 ]; then
echo "You pick up unix (Sun Os)";
else
	if [ $osch -eq 2 ] ; then
		echo "You pick up Linux (Red Hat)"
	else
		echo "What you don't link Unix/Linux OS.";	
	fi
fi
