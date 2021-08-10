import React from 'react';
import { createStyles, makeStyles, Theme } from '@material-ui/core/styles';
import IconButton from '@material-ui/core/IconButton';
import FilledInput from '@material-ui/core/FilledInput';
import InputLabel from '@material-ui/core/InputLabel';
import InputAdornment from '@material-ui/core/InputAdornment';
import FormControl from '@material-ui/core/FormControl';
import Visibility from '@material-ui/icons/Visibility';
import VisibilityOff from '@material-ui/icons/VisibilityOff';

const useStyles = makeStyles((theme: Theme) =>
    createStyles({
        input: {
            width: '100%'
        }
    }),
);

type PasswordInputProps = {
    name: string,
    passwordValue: string,
    // showPasswordValue: boolean,
    label: string,
    handleChange: (event: React.ChangeEvent<HTMLInputElement>) => void,
}

const PasswordInput = (props: PasswordInputProps) => {
    const classes = useStyles();

    const [showPassword, setShowPassword] = React.useState(false);

    const handleClickShowPassword = () => {
        let newValue = !showPassword
        setShowPassword(newValue);
    };

    const handleMouseDownPassword = (event: React.MouseEvent<HTMLButtonElement>) => {
        event.preventDefault();
    };

    return (
        <FormControl variant="filled" className={classes.input}>
            <InputLabel htmlFor="password-input">{props.label}</InputLabel>
            <FilledInput
                id="password-input"
                type={showPassword ? 'text' : 'password'}
                value={props.passwordValue}
                onChange={props.handleChange}
                name={props.name}
                endAdornment={
                    <InputAdornment position="end">
                        <IconButton
                            aria-label="toggle password visibility"
                            onClick={handleClickShowPassword}
                            onMouseDown={handleMouseDownPassword}
                            edge="end"
                        >
                            {showPassword ? <Visibility /> : <VisibilityOff />}
                        </IconButton>
                    </InputAdornment>
                }
            />
        </FormControl>
        // <TextField
        //     variant='filled'
        //     color='primary'
        //     type={props.type ? props.type : 'string'}
        //     label={props.label}
        //     value={props.value}
        //     name={props.name}
        //     onChange={props.handleChange}
        //     className={classes.input}
        // />
    );
}

export default PasswordInput;