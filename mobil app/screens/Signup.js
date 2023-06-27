import React, {useState} from 'react';
import { StatusBar } from 'expo-status-bar';

import { Formik } from 'formik';
import { View, TouchableOpacity, ActivityIndicator } from 'react-native';

//icons
import {Octicons, Ionicons, Fontisto} from '@expo/vector-icons';



import{
    StyledContainer,
    InnerContainer,
    PageLogo,
    PageTitle,
    SubTitle,
    StyledFormArea,
    LeftIcon,
    RightIcon,
    StyledButton,
    StyledInputLabel,
    StyledTextInput,
    ButtonText,
    Colors,
    MsgBox,
    Line,
    ExtraText,
    ExtraView,
    TextLink,
    TextLinkContent,
} from './../compontents/styles';

import axios from 'axios';

const {brand, darkLight, primary} = Colors;

import KeyboardAvoidingWrapper from '../compontents/KeyboardAvoidingWrapper';

const Signup = ({navigation}) => {
    const [hidePassword, setHidePassword] = useState(true);

    const [message, setMessage] = useState();
    const [messageType, setMessageType] = useState();

    const handleSignup = (credentials, setSubmitting) => {
        handleMessage(null);
        const url = 'http://192.168.26.218/Integralt/loginreg.php?op=signup';

        axios
        .post(url, credentials)
        .then((response) => {
                const result = response.data;
                const {message, status, data} = result;

                if(status !== 'SUCCESS'){
                    handleMessage(message, status);
                }else{
                    navigation.navigate("Welcome", {...data});
                }
                setSubmitting(false);
        })
        .catch(error=> {
            console.log(error.JSON());
            setSubmitting(false);
            handleMessage("Error! Ellenőrizze az internet kapcsolatát!");
        });
    };
    const handleMessage = (message, type = 'FAILED') => {
        setMessage(message);
        setMessageType(type);

    }

    return(
        <KeyboardAvoidingWrapper>
        <StyledContainer>
            <StatusBar style="dark"/>
            <InnerContainer>
                <PageTitle>StormSite</PageTitle>
                <SubTitle>Regisztráció</SubTitle>

                <Formik
                initialValues={{username: '', email: '', no_hash: '', confirmPassword: ''}}
                onSubmit={(values, {setSubmitting}) =>{
                    values={...values};
                    if(values.email== '' || values.no_hash == '' || values.username == '' || values.confirmPassword == ''){
                        handleMessage('Kérlek tölts ki minden mezőt!');
                        setSubmitting(false);
                    }else if(values.no_hash !== values.confirmPassword){
                        handleMessage('A jelszavak nem eggyeznek!');
                        setSubmitting(false);
                    }else{
                        handleSignup(values, setSubmitting);
                    }
                }}
                >{({handleChange, handleBlur, handleSubmit, values, isSubmitting})=> (<StyledFormArea>
                        <MyTextInput
                        label="Felhasználónév"
                        icon="person"
                        placeholder="Ezekiel"
                        placeholderTextColor={darkLight}
                        onChangeText={handleChange('username')}
                        onBlur={handleBlur('username')}
                        value={values.username}
                        />

                        <MyTextInput
                        label="Email"
                        icon="mail"
                        placeholder="Ezekiel@gmail.com"
                        placeholderTextColor={darkLight}
                        onChangeText={handleChange('email')}
                        onBlur={handleBlur('email')}
                        value={values.email}
                        keyboardType="email-address"
                        />

                        <MyTextInput
                        label="Jelszó"
                        icon="lock"
                        placeholder="* * * * * * * *"
                        placeholderTextColor={darkLight}
                        onChangeText={handleChange('no_hash')}
                        onBlur={handleBlur('no_hash')}
                        value={values.no_hash}
                        secureTextEntry={hidePassword}
                        isPassword={true}
                        hidePassword={hidePassword}
                        setHidePassword={setHidePassword}
                        />

                        <MyTextInput
                        label="Jelszó megerősítése"
                        icon="lock"
                        placeholder="* * * * * * * *"
                        placeholderTextColor={darkLight}
                        onChangeText={handleChange('confirmPassword')}
                        onBlur={handleBlur('confirmPassword')}
                        value={values.confirmPassword}
                        secureTextEntry={hidePassword}
                        isPassword={true}
                        hidePassword={hidePassword}
                        setHidePassword={setHidePassword}
                        />

                        <MsgBox type={messageType}>{message}</MsgBox>


                        {!isSubmitting &&
                        (<StyledButton onPress={handleSubmit}>
                            <ButtonText>
                                Bejelentkezés
                            </ButtonText>
                        </StyledButton>)}

                        {isSubmitting &&
                        <StyledButton disabled={true}>
                            <ActivityIndicator size="large" color={primary}/>
                        </StyledButton>}

                        
                        <Line />
                        <ExtraView>
                            <ExtraText>
                                Van már fiókja?
                            </ExtraText>
                            <TextLink onPress={() => navigation.navigate("Login")}>
                                <TextLinkContent>
                                    Belépés
                                </TextLinkContent>
                            </TextLink>
                        </ExtraView>

                </StyledFormArea>)}

                </Formik>
            </InnerContainer>
        </StyledContainer>
        </KeyboardAvoidingWrapper>
    );
};

const MyTextInput = ({label, icon, isPassword, hidePassword, setHidePassword, ...props}) => {

    return(
        <View>
        <LeftIcon>
            <Octicons name={icon} size={30} color={brand} />
        </LeftIcon>
        <StyledInputLabel>{label}</StyledInputLabel>
        <StyledTextInput {...props} />
        {isPassword && (
            <RightIcon onPress={()=> setHidePassword(!hidePassword)}>
                <Ionicons name={hidePassword ? 'md-eye-off' : 'md-eye'} size={30} color={darkLight}/>
            </RightIcon>
        )}
        </View>);
};

export default Signup;