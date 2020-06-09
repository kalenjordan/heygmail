rm /kj/starter/public/kj-keyboard-shortcuts.zip
cd /kj/starter/public
zip kj-keyboard-shortcuts.zip chrome-extension/*
scp kj-keyboard-shortcuts.zip squad:~/kalenjordan.com/public/kj-keyboard-shortcuts-v0.3.zip
