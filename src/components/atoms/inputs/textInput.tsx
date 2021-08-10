import React from 'react';
import { createStyles, makeStyles, Theme } from '@material-ui/core/styles';
import TextField from '@material-ui/core/TextField';

const useStyles = makeStyles((theme: Theme) =>
    createStyles({
        input: {
            width: '100%'
        }
    }),
);

type TextInputProps = {
    name: string,
    value: any,
    label: string,
    type?: string,
    // Cambiar a void (me esta dando error)
    handleChange: any,
}

const TextInput = (props: TextInputProps) => {
    const classes = useStyles();

    return (
        <TextField
            variant='filled'
            color='primary'
            type={props.type ? props.type : 'string'}
            label={props.label}
            value={props.value}
            name={props.name}
            onChange={props.handleChange}
            className={classes.input}
        />
    );
}

export default TextInput;