Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/xenial64"
  config.vm.provider :virtualbox do |v|
    v.memory = 2048
    v.cpus = 2
  end

   config.vm.network "forwarded_port", guest: 80, host: 8000
   config.vm.network "forwarded_port", guest: 3306, host: 3306

  config.vm.synced_folder ".", "/vagrant", type: "virtualbox"
  config.vm.provision :shell, path: "scripts/provision-vagrant.sh"
end
