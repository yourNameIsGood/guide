# .bashrc

# Source global definitions
if [ -f /etc/bashrc ]; then
    . /etc/bashrc
fi

#my function , cd then list all the files
mycd(){ 
    cd $1
    ll .  
}

# User specific aliases and functions
alias lla='ll -A'
alias llt='ls -lt'
alias rm='rm -i'
alias lll='ll'
alias l='ll'
alias cd=mycd
alias tomodel='cd /home/linzhen/ykworkflow/ykwf/app/Userlive/Model'
alias zz='export LANG=zh_CN.UTF-8'
alias ..='cd ..'
alias vimvimrc='vi ~/.vimrc'
alias vimbashrc='vi ~/.bashrc'

alias gs='git status'
alias gb='git branch'
alias gf='git fetch'
alias gd='git diff'
alias gmdev='git merge origin/develop'
alias gpush='git push origin feature/ul-mvfrontapi'

alias finddos='find . | xargs grep  -l'
alias findnotrdos='find [^R]* | xargs grep  -l'

alias megrep='sh ~/work/code/guide/myShell/megrep.sh'

# use ibus under Ubuntu, start ibus with this command
alias chinese='ibus-daemon -drx'
