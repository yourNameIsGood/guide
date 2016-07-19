# .bashrc

# Source global definitions
if [ -f /etc/bashrc ]; then
    . /etc/bashrc
fi

# User specific aliases and functions
alias lla='ll -A'
alias llt='ls -lt'
alias rm='rm -i'
alias lll='ll'
alias l='ll'
alias userlive='cd /home/linzhen/ykworkflow/ykwf/app/Userlive/Controller'
alias tomodel='cd /home/linzhen/ykworkflow/ykwf/app/Userlive/Model'
alias toapi='cd /home/linzhen/ykworkflow/ykwf/app/Userlive/API'
alias conf='cd /home/linzhen/ykworkflow/ykwf/conf'
alias ul='cd /home/linzhen/ullive/ykwf/app/Userlive/Controller'
alias zz='export LANG=zh_CN.UTF-8'

alias gs='git status'
alias gb='git branch'
alias gf='git fetch'
alias gd='git diff'
alias gmdev='git merge origin/develop'
alias gpush='git push origin feature/ul-mvfrontapi'

alias finddos='find . | xargs grep  -l'
alias findnotrdos='find [^R]* | xargs grep  -l'

