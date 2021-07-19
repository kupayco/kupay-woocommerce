import React from 'react';
import { makeStyles, createStyles, Theme } from '@material-ui/core/styles';
import Button from '@material-ui/core/Button';

const useStyles = makeStyles((theme: Theme) =>
  createStyles({
    button: {
      width: '100%',
    }
  }),
);

type FormButtonProps = {
  text: string,
  handleClick: () => void,
}

const FormButton = (props: FormButtonProps) => {
  const classes = useStyles();

  return (
    <Button variant="contained" color="primary" size='large' onClick={props.handleClick} className={classes.button}>
      {props.text}
    </Button>
  );
}

export default FormButton;