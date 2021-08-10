import React from 'react';
import { createStyles, Theme, makeStyles, useTheme } from '@material-ui/core/styles';
import Typography from '@material-ui/core/Typography';

const useStyles = makeStyles((theme: Theme) =>
    createStyles({

    }),
);

type TitleWithSubtitleProps = {
    title: string,
    subtitle: string,
}

const TitleWithSubtitle = (props: TitleWithSubtitleProps) => {
    const classes = useStyles();
    const theme = useTheme();

    return (
        <>
            <Typography variant='h3' color='textPrimary' align='center' style={{ marginBottom: theme.spacing(1) }}>
                {props.title}
            </Typography>
            <Typography variant='h5' color='textSecondary' align='center'>
                {props.subtitle}
            </Typography>
        </>
    );
}

export default TitleWithSubtitle;