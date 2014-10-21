# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

VM_HOSTNAME = "helpful-wordpress.local"
VM_ADDRESS = "192.168.11.37"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "chef/fedora-20"

  config.vm.hostname = VM_HOSTNAME
  config.vm.network :private_network, ip: VM_ADDRESS

  config.ssh.forward_agent = true

  config.vm.provider :virtualbox do |vb|
    vb.name = "helpful-wordpress-development"

    vb.customize ['modifyvm', :id, '--cpus', '4']
    vb.customize ['modifyvm', :id, '--ioapic', 'on']
    vb.customize ['modifyvm', :id, '--memory', '2048']

    vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
  end

  config.vm.provision "shell", inline: "sed -i s/enabled=1/enabled=0/ /etc/yum.repos.d/fedora-updates-testing.repo"
  config.vm.provision "shell", path: "provision/scripts/fix-slow-dns.sh"
  config.vm.provision "shell", path: "provision/vagrant-bootstrap.sh"
end
