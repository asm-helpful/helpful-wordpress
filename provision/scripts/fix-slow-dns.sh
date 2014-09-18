#!/bin/bash
# Last Updated: 2014-09-14 11:37 UTC-5
# Found here: https://github.com/mitchellh/vagrant/issues/1172#issuecomment-42263664

# fix bug to enable nm-dispatcher on Fedora 19 only https://bugzilla.redhat.com/show_bug.cgi?id=974811
if [[ $(rpm -q --queryformat '%{VERSION}\n' fedora-release) == 19 ]]; then
  if ! ( rpm -qa | grep NetworkManager ); then
    yum install -y NetworkManager
  else
    yum upgrade -y NetworkManager
  fi

  systemctl enable NetworkManager-dispatcher.service
fi

if [[ ! -x /etc/NetworkManager/dispatcher.d/fix-slow-dns ]]; then
    cat > /etc/NetworkManager/dispatcher.d/fix-slow-dns <<EOF
#!/bin/bash
if ! ( grep single-request-reopen /etc/resolv.conf ); then
  echo "options single-request-reopen" >> /etc/resolv.conf
fi
EOF

    chmod +x /etc/NetworkManager/dispatcher.d/fix-slow-dns
    systemctl restart NetworkManager
fi
