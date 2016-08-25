# ~/.bashrc: executed by bash(1) for non-login shells.
# see /usr/share/doc/bash/examples/startup-files (in the package bash-doc)
# for examples

# If not running interactively, don't do anything
case $- in
    *i*) ;;
      *) return;;
esac

# don't put duplicate lines or lines starting with space in the history.
# See bash(1) for more options
HISTCONTROL=ignoreboth

# append to the history file, don't overwrite it
shopt -s histappend

# for setting history length see HISTSIZE and HISTFILESIZE in bash(1)
HISTSIZE=1000
HISTFILESIZE=2000

# check the window size after each command and, if necessary,
# update the values of LINES and COLUMNS.
shopt -s checkwinsize

# If set, the pattern "**" used in a pathname expansion context will
# match all files and zero or more directories and subdirectories.
#shopt -s globstar

# make less more friendly for non-text input files, see lesspipe(1)
[ -x /usr/bin/lesspipe ] && eval "$(SHELL=/bin/sh lesspipe)"

# set variable identifying the chroot you work in (used in the prompt below)
if [ -z "${debian_chroot:-}" ] && [ -r /etc/debian_chroot ]; then
    debian_chroot=$(cat /etc/debian_chroot)
fi

# set a fancy prompt (non-color, unless we know we "want" color)
case "$TERM" in
    xterm-color|*-256color) color_prompt=yes;;
esac

# uncomment for a colored prompt, if the terminal has the capability; turned
# off by default to not distract the user: the focus in a terminal window
# should be on the output of commands, not on the prompt
#force_color_prompt=yes

if [ -n "$force_color_prompt" ]; then
    if [ -x /usr/bin/tput ] && tput setaf 1 >&/dev/null; then
	# We have color support; assume it's compliant with Ecma-48
	# (ISO/IEC-6429). (Lack of such support is extremely rare, and such
	# a case would tend to support setf rather than setaf.)
	color_prompt=yes
    else
	color_prompt=
    fi
fi

if [ "$color_prompt" = yes ]; then
    PS1='${debian_chroot:+($debian_chroot)}\[\033[01;32m\]\u@\h\[\033[00m\]:\[\033[01;34m\]\w\[\033[00m\]\$ '
else
    PS1='${debian_chroot:+($debian_chroot)}\u@\h:\w\$ '
fi
unset color_prompt force_color_prompt

# If this is an xterm set the title to user@host:dir
case "$TERM" in
xterm*|rxvt*)
    PS1="\[\e]0;${debian_chroot:+($debian_chroot)}\u@\h: \w\a\]$PS1"
    ;;
*)
    ;;
esac

# enable color support of ls and also add handy aliases
if [ -x /usr/bin/dircolors ]; then
    test -r ~/.dircolors && eval "$(dircolors -b ~/.dircolors)" || eval "$(dircolors -b)"
    alias ls='ls --color=auto'
    #alias dir='dir --color=auto'
    #alias vdir='vdir --color=auto'

    alias grep='grep --color=auto'
    alias fgrep='fgrep --color=auto'
    alias egrep='egrep --color=auto'
fi

# colored GCC warnings and errors
#export GCC_COLORS='error=01;31:warning=01;35:note=01;36:caret=01;32:locus=01:quote=01'

# some more ls aliases
alias ll='ls -alF'
alias la='ls -A'
alias l='ls -CF'

# Add an "alert" alias for long running commands.  Use like so:
#   sleep 10; alert
alias alert='notify-send --urgency=low -i "$([ $? = 0 ] && echo terminal || echo error)" "$(history|tail -n1|sed -e '\''s/^\s*[0-9]\+\s*//;s/[;&|]\s*alert$//'\'')"'

# Alias definitions.
# You may want to put all your additions into a separate file like
# ~/.bash_aliases, instead of adding them here directly.
# See /usr/share/doc/bash-doc/examples in the bash-doc package.

if [ -f ~/.bash_aliases ]; then
    . ~/.bash_aliases
fi

# enable programmable completion features (you don't need to enable
# this, if it's already enabled in /etc/bash.bashrc and /etc/profile
# sources /etc/bash.bashrc).
if ! shopt -oq posix; then
  if [ -f /usr/share/bash-completion/bash_completion ]; then
    . /usr/share/bash-completion/bash_completion
  elif [ -f /etc/bash_completion ]; then
    . /etc/bash_completion
  fi
fi

mycd(){ 
    cd $1
    ll .  
}

# Randy's bash config
alias lla='ll -A'
alias llt='ls -lt'
alias lll='ll'
alias l='ll'
alias zz='export LANG=zh_CN.UTF-8'
alias ..='cd ..'
alias cd=mycd
alias vimvimrc='vi ~/.vimrc'
alias vimbashrc='vi ~/.bashrc'
alias bashup='. ~/.bashrc'
alias bbb='bashup'

# git shortcuts
alias gs='git status'
alias ga='git add .'
alias gb='git branch'
alias gf='git fetch'
alias gd='git diff'
alias gmdev='git merge origin/develop'
alias gitmergeoriginmaster='git merge origin/master'
alias gitpushoriginmaster='git push origin master'

alias finddos='find . | xargs grep  -l'
alias findnotrdos='find [^R]* | xargs grep  -l'
alias megrep='sh ~/work/code/guide/myShell/megrep.sh'
alias psef='sh ~/work/code/guide/myShell/psef.sh'

alias jsonformat='python -m json.tool '

alias dstcp='dstat -cdlmnpsy --tcp'
alias tm='tmux'

# commit diary and backup code
alias commitdiary='rm -f /home/randylin/work/diary/.git/index.lock && sh /home/randylin/work/code/guide/myShell/codeBackup.sh'
alias commitbackup='commitdiary'
alias vimdiary='vim ~/work/diary/docs/diary.md'

# ssh without typing pwd
alias ssh77='sshpass -p jesse ssh jesse@10.6.8.77'
alias ssh72='sshpass -p jesse ssh jesse@10.6.8.72'

#########################
# CONFIG ON THIS SERVER #
#########################
alias chinese='ibus-daemon -drx'
alias tow='cd /home/randylin/work/'
alias towork='cd /home/randylin/work/'
alias toc='cd /home/randylin/work/code/'
alias tocode='cd /home/randylin/work/code/'
alias todownload='cd ~/下载'
alias tod='todownload'
alias tomongo='cd /usr/local/mongodb/bin'
alias todataapi='cd ~/work/code/data_api/trunk/l7datawebapi'
alias tosocportal='cd ~/work/code/soc_portal/soc_portal/trunk/App'

export NVM_DIR="/home/randylin/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"  # This loads nvm

# open robomongo
alias robomongo='/home/randylin/下载/robomongo/bin/robomongo &'

#data api related
alias startdataapi='sh ~/work/code/data_api/trunk/l7datawebapi/ctl.sh start'
alias stopdataapi='sh ~/work/code/data_api/trunk/l7datawebapi/ctl.sh stop'

alias rrr='php crontab.php backup_dataapi/api/spe_mitigation_traffic_idc/starttime/1470882396/endtime/1470885996/interval/1min'

alias run10min='php crontab.php backup_dataapi/api/spe_mitigation_traffic_idc/interval/10min'
alias run1hour='php crontab.php backup_dataapi/api/spe_mitigation_traffic_idc/interval/1hour'
alias rrrr='run10min'
alias testcachebackup='php crontab.php test_cache_backup/api/spe_mitigation_traffic_idc/idc/bj/spe_gid/5/starttime/1470882396/endtime/1470885996/interval/1min'
