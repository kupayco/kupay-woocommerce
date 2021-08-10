import React from 'react';
import { createStyles, Theme, makeStyles } from '@material-ui/core/styles';
import Typography from '@material-ui/core/Typography';

const useStyles = makeStyles((theme: Theme) =>
    createStyles({
        imgContainer: {
            paddingLeft: theme.spacing(4),
            paddingRight: theme.spacing(4)
        },
        img: {
            width: '100%'
        },
        text: {
            marginTop: theme.spacing(1)
        }
    }),
);

type IconWithTextProps = {
    icon: string,
    text: string,
}

const IconWithText = (props: IconWithTextProps) => {
    const classes = useStyles();

    return (
        <>
            <div className={classes.imgContainer}>
                <img src={props.icon} alt={props.text} className={classes.img} />
            </div>
            <Typography variant='body2' color='textPrimary' align='center' className={classes.text}>
                {props.text}
            </Typography>
        </>
    );
}

export default IconWithText;