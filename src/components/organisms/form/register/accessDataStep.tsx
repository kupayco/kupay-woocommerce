// Utils & Config
import React from 'react';
import { createStyles, Theme, makeStyles } from '@material-ui/core/styles';

// External Components
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';


// Internal Components
import TitleWithSubtitle from '../../../molecules/titleWithSubtitle'
import IconWithText from '../../../molecules/iconWithText';
import TextInput from '../../../atoms/inputs/textInput';
import FormButton from '../../../atoms/formButton';

const useStyles = makeStyles((theme: Theme) =>
    createStyles({

    }),
);

type FormData = {
    email: string,
    password: string,
}

type AccessDataStepProps = {
    data: FormData,
    handleChangeInput: (event: React.ChangeEvent<HTMLInputElement>) => void,
    handleSubmitAccessData: () => void
}

const AccessDataStep = (props: AccessDataStepProps) => {
    const classes = useStyles();

    return (
        <Grid container spacing={2}>
            <Grid item xs={12}>
                <TitleWithSubtitle title='Registrate en KuPay' subtitle='y paga en un clic' />
            </Grid>
            <Grid item xs={12}>
                <TextInput name='email' value={props.data.email} label='Correo electrónico' handleChange={props.handleChangeInput} />
            </Grid>
            <Grid item xs={12}>
                <TextInput name='password' value={props.data.password} label='Contraseña' handleChange={props.handleChangeInput} />
            </Grid>
            <Grid item xs={4}>
                <IconWithText icon='/fast.svg' text='Ahorre tiempo' />
            </Grid>
            <Grid item xs={4}>
                <IconWithText icon='/credit-card.svg' text='Todas las tarjetas, 1 lugar' />
            </Grid>
            <Grid item xs={4}>
                <IconWithText icon='/gift-box.svg' text='Gana premios' />
            </Grid>
            <Grid item xs={12}>
                <Typography variant='body2' color='textSecondary' align='center'>
                    By clicking the button below you agree to our Terms, Privacy Policy and Cookie Policy
                </Typography>
            </Grid>
            <Grid item xs={12}>
                <FormButton text='Registrarse' handleClick={props.handleSubmitAccessData} />
            </Grid>
            <Grid item xs={12}>
                <Typography variant='body2' color='textSecondary' align='center'>
                    ¿Ya tienes cuenta? Ingresa aquí
                </Typography>
            </Grid>
        </Grid>
    );
}

export default AccessDataStep;