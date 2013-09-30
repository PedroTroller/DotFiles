TMUX_POWERLINE_SEPARATOR_LEFT_BOLD="◀"
TMUX_POWERLINE_SEPARATOR_LEFT_THIN="❮"
TMUX_POWERLINE_SEPARATOR_RIGHT_BOLD="▶"
TMUX_POWERLINE_SEPARATOR_RIGHT_THIN="❯"

TMUX_POWERLINE_DEFAULT_BACKGROUND_COLOR=${TMUX_POWERLINE_DEFAULT_BACKGROUND_COLOR:-'300'}
TMUX_POWERLINE_DEFAULT_FOREGROUND_COLOR=${TMUX_POWERLINE_DEFAULT_FOREGROUND_COLOR:-'255'}

TMUX_POWERLINE_DEFAULT_LEFTSIDE_SEPARATOR=${TMUX_POWERLINE_DEFAULT_LEFTSIDE_SEPARATOR:-$TMUX_POWERLINE_SEPARATOR_RIGHT_BOLD}
TMUX_POWERLINE_DEFAULT_RIGHTSIDE_SEPARATOR=${TMUX_POWERLINE_DEFAULT_RIGHTSIDE_SEPARATOR:-$TMUX_POWERLINE_SEPARATOR_LEFT_BOLD}


# Format: segment_name background_color foreground_color [non_default_separator]

if [ -z $TMUX_POWERLINE_LEFT_STATUS_SEGMENTS ]; then
    TMUX_POWERLINE_LEFT_STATUS_SEGMENTS=(
        "tmux_session_info 300 255 ${TMUX_POWERLINE_SEPARATOR_RIGHT_THIN}" \
        "hostname 300 255 ${TMUX_POWERLINE_SEPARATOR_RIGHT_THIN}" \
        "lan_ip 300 255 ${TMUX_POWERLINE_SEPARATOR_RIGHT_THIN}" \
        "wan_ip 300 255 ${TMUX_POWERLINE_SEPARATOR_RIGHT_THIN}" \
        )
fi

if [ -z $TMUX_POWERLINE_RIGHT_STATUS_SEGMENTS ]; then
    TMUX_POWERLINE_RIGHT_STATUS_SEGMENTS=(
        "date 300 255 ${TMUX_POWERLINE_SEPARATOR_LEFT_THIN}" \
        "time 300 255 ${TMUX_POWERLINE_SEPARATOR_LEFT_THIN}" \
        )
fi
