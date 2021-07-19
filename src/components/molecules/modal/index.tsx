// Utils & Config
import React from 'react';
import { createStyles, Theme, makeStyles } from '@material-ui/core/styles';

// External Components
import Dialog from '@material-ui/core/Dialog';
import DialogContent from '@material-ui/core/DialogContent';
import DialogTitle from '@material-ui/core/DialogTitle';
import IconButton from '@material-ui/core/IconButton';
import CloseIcon from '@material-ui/icons/Close';

// Internal Components


const useStyles = makeStyles((theme: Theme) =>
    createStyles({
        title: {
            borderBottom: `1px solid rgba(0,0,0,0.2)`,
            '& h2': {
                display: 'flex',
                justifyContent: 'space-between',
                alignItems: 'center',
            }
        },
        iconButton: {
            padding: '0px',
        },
        content: {
            padding: `${theme.spacing(2)}px ${theme.spacing(3)}px`
        },
    }),
);

type ModalProps = {
    title: string,
    open: boolean,
    handleClose: () => void,
    children: React.ReactNode
}

const Modal = (props: ModalProps) => {
    const classes = useStyles();

    return (
        <>
            <Dialog
                fullWidth={true}
                maxWidth='xs'
                open={props.open}
                onClose={props.handleClose}
                aria-labelledby="kupai-modal"
            >
                <DialogTitle id="kupai-modal-title" className={classes.title}>
                    {props.title}
                    <IconButton aria-label="close-modal" onClick={props.handleClose} className={classes.iconButton}>
                        <CloseIcon />
                    </IconButton>
                </DialogTitle>
                <DialogContent className={classes.content}>
                    {props.children}
                </DialogContent>
            </Dialog>
        </>
    );
}

export default Modal;