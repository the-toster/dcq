#!/bin/sh

cat installer-template.sh > installer.sh
sed "s/.*/echo '&' >> \$INSTALL_TO/" dcq >> installer.sh

echo 'chmod +x $INSTALL_TO' >> installer.sh
echo 'echo "dcq successfully installed to $INSTALL_TO"' >> installer.sh